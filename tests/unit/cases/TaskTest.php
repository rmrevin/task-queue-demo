<?php
/**
 * TaskTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\Task\Account;
use Plp\Task\Domain;
use Plp\Task\Integration;
use Plp\Task\Message;
use Plp\tests\unit\TestCase;

/**
 * Class TaskTest
 * @package Plp\tests\unit\cases
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

        $this->assertInstanceOf('Plp\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('Plp\Task\Account::bill
', $Task->result);
    }

    public function testDomain()
    {
        $Task = new Domain;
        $Task->setAttributes([
            'task' => 'domain',
            'action' => 'addzone',
        ]);

        $this->assertInstanceOf('Plp\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('Plp\Task\Domain::addzone
', $Task->result);
    }

    public function testIntegration()
    {
        $Task = new Integration;
        $Task->setAttributes([
            'task' => 'integration',
            'action' => 'process',
        ]);

        $this->assertInstanceOf('Plp\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('Plp\Task\Integration::process
', $Task->result);
    }

    public function testMessage()
    {
        $Task = new Message;
        $Task->setAttributes([
            'task' => 'message',
            'action' => 'sms',
        ]);

        $this->assertInstanceOf('Plp\Task\AbstractTask', $Task);

        $Task->execute();

        $this->assertEquals('Plp\Task\Message::sms
', $Task->result);
    }
}