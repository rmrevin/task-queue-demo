<?php
/**
 * Database_TestCase.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit;

use Plp\components\PDOContainer;

/**
 * Class Database_TestCase
 * @package Plp\tests\unit
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