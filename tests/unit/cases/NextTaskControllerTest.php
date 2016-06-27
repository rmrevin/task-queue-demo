<?php
/**
 * NextTaskControllerTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\components\Config;
use TQ\components\PDOContainer;
use TQ\controllers\NextTaskController;
use TQ\tests\unit\components\TestIO;
use TQ\tests\unit\Database_TestCase;

/**
 * Class NextTaskControllerTest
 * @package TQ\tests\unit\cases
 */
class NextTaskControllerTest extends Database_TestCase
{

    public function setUp()
    {
        parent::setUp();

        Config::set('sleep.on-empty', 1);
    }

    public function testMain()
    {
        $IO = new TestIO;

        $Controller = new NextTaskController;
        $Controller->stdio = $IO;

        $Controller->run();

        $this->assertContains('call task domain::addzone() id#2971107', $IO->stdout);
        $this->assertContains('TQ\Task\Domain::addzone', $IO->stdout);

        PDOContainer::get()
            ->perform('UPDATE task SET status = 2')
            ->execute();

        $IO->flush();

        $Controller->run();

        $this->assertContains('Active task not found. Waiting 1 sec...', $IO->stdout);
    }
}