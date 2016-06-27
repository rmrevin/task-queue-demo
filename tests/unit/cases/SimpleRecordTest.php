<?php
/**
 * SimpleRecordTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\Task\Domain;
use TQ\tests\unit\TestCase;

/**
 * Class SimpleRecordTest
 * @package TQ\tests\unit\cases
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