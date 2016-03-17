<?php
/**
 * AbstractTask.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\Task;

use PDO;
use Plp\components\Config;
use Plp\components\Formatter;
use Plp\components\PDOContainer;
use Plp\components\SimpleRecord;

/**
 * Class AbstractTask
 * @package Plp\Task
 */
abstract class AbstractTask extends SimpleRecord
{

    public $id;
    public $account_id;
    public $created;
    public $deffer;
    public $type;
    public $task;
    public $action;
    public $data;
    public $status;
    public $retries;
    public $finished;
    public $result;

    /**
     * @return bool|mixed
     */
    public function execute()
    {
        $result = false;

        $class = sprintf('Plp\Task\%s', ucfirst($this->task));
        $method = $this->action;
        $data = empty($this->data) ? null : json_decode($this->data, true);

        try {
            $this->result = call_user_func([$class, $method], $data);

            $this->status = static::STATUS_DONE;
            $this->finished = Formatter::databaseTime();

            $result = PDOContainer::get()
                ->perform('UPDATE task SET status = :status_done, result = :result, finished = :now WHERE id = :id', [
                    'id' => $this->id,
                    'result' => $this->result,
                    'status_done' => $this->status,
                    'now' => $this->finished, // пришлось отказаться от NOW() для поддержки тестов в sqlite
                ])->execute();

        } catch (UserException $e) {
            $this->setError(sprintf('User error: %s', $e->getMessage()), true);
        } catch (FatalException $e) {
            $this->setError(sprintf('Fatal error: %s', $e->getMessage()), false);
        }

        return $result;
    }

    /**
     * @param integer $status
     * @return bool
     */
    public function setStatus($status)
    {
        return PDOContainer::get()
            ->perform('UPDATE task SET status = :status WHERE id = :id', [
                'id' => $this->id,
                'status' => $status,
            ])->execute();
    }

    /**
     * @param string $message
     * @param boolean $try_again
     * @return bool
     */
    public function setError($message, $try_again = false)
    {
        $this->retries++;
        $this->result = $message;
        $this->status = static::STATUS_ERROR;

        $statement = 'UPDATE task SET status = :status_error, result = :message, retries = :retries WHERE id = :id';

        $params = [
            'id' => $this->id,
            'message' => $message,
            'status_error' => $this->status,
            'retries' => $this->retries,
        ];

        if ($try_again && $this->retries < 3) {
            $statement = 'UPDATE task SET status = :status_new, result = :message, retries = :retries, deffer = :deffer WHERE id = :id';

            $deffer_time = strtotime(sprintf('+%d sec', Config::get('deffer-time')));

            $this->status = static::STATUS_NEW;
            $this->deffer = Formatter::databaseTime($deffer_time);

            $params = [
                'id' => $this->id,
                'message' => $message,
                'status_new' => $this->status,
                'retries' => $this->retries,
                'deffer' => $this->deffer,
            ];
        }

        return PDOContainer::get()
            ->perform($statement, $params)
            ->execute();
    }

    /**
     * @param integer $id
     * @return AbstractTask|null
     */
    public static function find($id)
    {
        $task = null;

        $data = PDOContainer::get()
            ->perform('SELECT * FROM task WHERE id = :id', [
                'id' => $id,
            ])
            ->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $task = static::prepareTask($data);
        }

        return $task;
    }

    /**
     * @return AbstractTask|null
     */
    public static function getNextTask()
    {
        $task = null;

        $data = PDOContainer::get()
            ->perform('SELECT * FROM task WHERE (status = :status_new OR status IS NULL) AND (deffer IS NULL OR deffer <= :now) ORDER BY id ASC LIMIT 1', [
                'status_new' => static::STATUS_NEW,
                'now' => Formatter::databaseTime(), // пришлось отказаться от NOW() для поддержки тестов в sqlite
            ])
            ->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $task = static::prepareTask($data);
        }

        return $task;
    }

    /**
     * @param array $data
     * @return static|false
     */
    public static function prepareTask(array $data)
    {
        /**
         * @param integer $id
         * @param string $message
         */
        $throwError = function ($id, $message) {
            PDOContainer::get()
                ->perform('UPDATE task SET status = :status_error, result = :message WHERE id = :id', [
                    'id' => $id,
                    'message' => $message,
                    'status_error' => static::STATUS_ERROR,
                ])->execute();

            throw new \RuntimeException($message);
        };

        $class = sprintf('Plp\Task\%s', ucfirst($data['task']));

        if (empty($data['task'])) {
            $throwError($data['id'], sprintf('Bad task configuration: empty task.'));
        } elseif (!class_exists($class)) {
            $throwError($data['id'], sprintf('Class `%s` not found.', $class));
        } elseif (empty($data['action'])) {
            $throwError($data['id'], sprintf('Bad task configuration: empty action.'));
        } elseif (!method_exists($class, $data['action'])) {
            $throwError($data['id'], sprintf('Method `%s` not found in class `%s`.', $data['action'], $class));
        }

        /** @var static $object */
        $object = new $class;
        $object->setAttributes($data);

        return $object;
    }

    const STATUS_NEW = 0;
    const STATUS_WIP = 1;
    const STATUS_DONE = 2;
    const STATUS_ERROR = 3;
}