<?php
/**
 * TaskTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\Task\Account;
use TQ\Task\Domain;
use TQ\Task\Integration;
use TQ\Task\Message;
use TQ\tests\unit\TestCase;

/**
 * Class TaskTest
 * @package TQ\tests\unit\cases
 */
class TaskTest extends TestCase
{

    public function testAccount()
    {
        $Task = new Account;
        $Task->setAttributes([
            'task' => 'account',
            'action' => 'bill',
        ]);

        $this->assertInstanceOf('TQ\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('TQ\Task\Account::bill
', $Task->result);
    }

    public function testDomain()
    {
        $Task = new Domain;
        $Task->setAttributes([
            'task' => 'domain',
            'action' => 'addzone',
        ]);

        $this->assertInstanceOf('TQ\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('TQ\Task\Domain::addzone
', $Task->result);
    }

    public function testIntegration()
    {
        $Task = new Integration;
        $Task->setAttributes([
            'task' => 'integration',
            'action' => 'process',
        ]);

        $this->assertInstanceOf('TQ\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('TQ\Task\Integration::process
', $Task->result);
    }

    public function testMessage()
    {
        $Task = new Message;
        $Task->setAttributes([
            'task' => 'message',
            'action' => 'sms',
        ]);

        $this->assertInstanceOf('TQ\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('TQ\Task\Message::sms
', $Task->result);
    }
}