<?php
/**
 * ConfigTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\components\Config;
use TQ\tests\unit\TestCase;

/**
 * Class ConfigTest
 * @package TQ\tests\unit\cases
 */
class ConfigTest extends TestCase
{

    public function testGet()
    {
        $this->assertNotEmpty(Config::get());
        $this->assertNotEmpty(Config::get('deffer-time'));
        $this->assertEmpty(Config::get('non-exists-key'));
    }

    public function testSet()
    {
        Config::set('test', 'ok');

        $this->assertEquals('ok', Config::get('test'));
    }
}