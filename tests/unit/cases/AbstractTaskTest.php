<?php
/**
 * AbstractTaskTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\Task\AbstractTask;
use Plp\Task\BadTask;
use Plp\tests\unit\Database_TestCase;

/**
 * Class AbstractTaskTest
 * @package Plp\tests\unit\cases
 */
class AbstractTaskTest extends Database_TestCase
{

    public function testMain()
    {
        $this->assertEquals(10, $this->getConnection()->getRowCount('task'));
    }

    public function testGetNextTask()
    {
        $Task = AbstractTask::getNextTask();

        $this->assertInstanceOf('Plp\Task\Domain', $Task);
        $this->assertEquals(2971107, $Task->id);
    }

    public function testFind()
    {
        $Task = AbstractTask::find(2971107);

        $this->assertInstanceOf('Plp\Task\Domain', $Task);
        $this->assertEquals(2971107, $Task->id);
    }

    public function testSetStatus()
    {
        $Task = AbstractTask::find(2971107);
        $Task->setStatus(AbstractTask::STATUS_WIP);

        $UpdatedTask = AbstractTask::find(2971107);
        $this->assertEquals(AbstractTask::STATUS_WIP, $UpdatedTask->status);
    }

    public function testSetError()
    {
        $Task = AbstractTask::find(2971107);
        $Task->setError('Test error');

        $UpdatedTask = AbstractTask::find(2971107);
        $this->assertEquals(AbstractTask::STATUS_ERROR, $UpdatedTask->status);
        $this->assertEquals('"Test error"', $UpdatedTask->result);
        $this->assertEquals(1, $UpdatedTask->retries);

        $Task = AbstractTask::find(2971107);
        $Task->setError('Test error with additional trying', true);

        $UpdatedTask = AbstractTask::find(2971107);
        $this->assertEquals(AbstractTask::STATUS_NEW, $UpdatedTask->status);
        $this->assertEquals('"Test error with additional trying"', $UpdatedTask->result);
        $this->assertEquals(2, $UpdatedTask->retries);
        $this->assertNotEmpty($UpdatedTask->deffer);
    }

    public function testExecute()
    {
        $Task = AbstractTask::find(2971107);

        $result = $Task->execute();

        $this->assertTrue($result);
        $this->assertEquals(AbstractTask::STATUS_DONE, $Task->status);
        $this->assertNotEmpty($Task->finished);
        $this->assertEquals('Plp\Task\Domain::addzone
Array
(
    [domain] => mydomain.ru
)
', $Task->result);
    }

    public function testUserException()
    {
        $Task = new BadTask;
        $Task->setAttributes([
            'id' => 1,
            'account_id' => 1,
            'created' => null,
            'deffer' => null,
            'type' => null,
            'task' => 'badTask',
            'action' => 'user',
            'data' => null,
            'status' => AbstractTask::STATUS_NEW,
            'retries' => 0,
            'finished' => null,
            'result' => null,
        ]);

        $Task->execute();

        $this->assertEquals('User error: User bad task', $Task->result);
        $this->assertEquals(AbstractTask::STATUS_NEW, $Task->status);
        $this->assertEquals(1, $Task->retries);
    }

    public function testFatalException()
    {
        $Task = new BadTask;
        $Task->setAttributes([
            'id' => 1,
            'account_id' => 1,
            'created' => null,
            'deffer' => null,
            'type' => null,
            'task' => 'badTask',
            'action' => 'fatal',
            'data' => null,
            'status' => AbstractTask::STATUS_NEW,
            'retries' => 0,
            'finished' => null,
            'result' => null,
        ]);

        $Task->execute();

        $this->assertEquals('Fatal error: Fatal bad task', $Task->result);
        $this->assertEquals(AbstractTask::STATUS_ERROR, $Task->status);
        $this->assertEquals(1, $Task->retries);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadTaskConfigurationClassNotExists()
    {
        AbstractTask::find(2971620);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadTaskConfigurationClassEmpty()
    {
        AbstractTask::find(2971621);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadTaskConfigurationActionNotExists()
    {
        AbstractTask::find(2971622);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testBadTaskConfigurationActionEmpty()
    {
        AbstractTask::find(2971623);
    }
}