<?php
/**
 * NextTaskController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\controllers;

use Aura\Cli\Stdio;
use Plp\components\Config;
use Plp\components\Formatter;
use Plp\Task\AbstractTask;

/**
 * Class NextTaskController
 * @package Plp\controllers
 */
class NextTaskController
{

    /** @var Stdio */
    public $stdio;

    public function run()
    {
        $Task = AbstractTask::getNextTask();

        if (empty($Task)) {
            $this->stdio->out('Active task not found. ');

            if (($sec = (int)Config::get('sleep.on-empty')) > 0) {
                $this->stdio->out(sprintf('Waiting %d sec... ', $sec));

                sleep($sec);
            }

            $this->stdio->outln('Next try.');
        } else {
            $Task->setStatus(AbstractTask::STATUS_WIP);

            $this->stdio->outln('----------------------------------------------');
            $this->stdio->outln(sprintf('  > %s', Formatter::get()->formatObject(new \DateTime(), \IntlDateFormatter::SHORT)));
            $this->stdio->outln(sprintf('  > call task %s::%s() id#%d', $Task->task, $Task->action, $Task->id));

            $Task->execute();

            $this->stdio->outln(sprintf('  > %s', $Task->result));
            $this->stdio->outln('----------------------------------------------');

            if (($sec = (int)Config::get('sleep.after-step')) > 0) {
                sleep(Config::get('sleep.after-step'));
            }
        }
    }
}