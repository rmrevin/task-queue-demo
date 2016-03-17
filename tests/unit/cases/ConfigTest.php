<?php
/**
 * ConfigTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\components\Config;
use Plp\tests\unit\TestCase;

/**
 * Class ConfigTest
 * @package Plp\tests\unit\cases
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