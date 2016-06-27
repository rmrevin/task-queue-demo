<?php
/**
 * Database_TestCase.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit;

use TQ\components\PDOContainer;

/**
 * Class Database_TestCase
 * @package TQ\tests\unit
 */
class Database_TestCase extends \PHPUnit_Extensions_Database_TestCase
{

    /**
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(PDOContainer::get(), ':memory:');
    }

    /**
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        $data = file_get_contents(__DIR__ . '/../../data/task.json');

        return $this->createArrayDataSet([
            'task' => json_decode($data, true),
        ]);
    }
}