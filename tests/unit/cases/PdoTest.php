<?php
/**
 * PdoTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\components\PDOContainer;
use Plp\tests\unit\TestCase;

/**
 * Class PdoTest
 * @package Plp\tests\unit\cases
 */
class PdoTest extends TestCase
{

    public function testMain()
    {
        $PDO = PDOContainer::get();

        $this->assertInstanceOf('Aura\Sql\ExtendedPdo', $PDO);

        $this->assertEquals([1 => '1'], $PDO->perform('SELECT 1')->fetch(\PDO::FETCH_ASSOC));
    }
}