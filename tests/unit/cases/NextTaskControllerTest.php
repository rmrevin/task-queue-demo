<?php
/**
 * NextTaskControllerTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\components\Config;
use Plp\components\PDOContainer;
use Plp\controllers\NextTaskController;
use Plp\tests\unit\components\TestIO;
use Plp\tests\unit\Database_TestCase;

/**
 * Class NextTaskControllerTest
 * @package Plp\tests\unit\cases
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
        $this->assertContains('Plp\Task\Domain::addzone', $IO->stdout);

        PDOContainer::get()
            ->perform('UPDATE task SET status = 2')
            ->execute();

        $IO->flush();

        $Controller->run();

        $this->assertContains('Active task not found. Waiting 1 sec...', $IO->stdout);
    }
}