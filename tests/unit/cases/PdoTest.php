<?php
/**
 * PdoTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\components\PDOContainer;
use TQ\tests\unit\TestCase;

/**
 * Class PdoTest
 * @package TQ\tests\unit\cases
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