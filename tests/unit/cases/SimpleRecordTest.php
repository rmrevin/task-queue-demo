<?php
/**
 * SimpleRecordTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\tests\unit\cases;

use Plp\Task\Domain;
use Plp\tests\unit\TestCase;

/**
 * Class SimpleRecordTest
 * @package Plp\tests\unit\cases
 */
class SimpleRecordTest extends TestCase
{

    public function testMain()
    {
        $Task = new Domain();

        $Task->setAttributes([
            'id' => 9832,
            'account_id' => 5634,
        ]);

        $this->assertEquals(9832, $Task->id);
        $this->assertEquals(5634, $Task->account_id);
    }
}