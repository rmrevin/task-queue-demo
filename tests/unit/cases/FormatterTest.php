<?php
/**
 * FormatterTest.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\cases;

use TQ\components\Formatter;
use TQ\tests\unit\TestCase;

/**
 * Class FormatterTest
 * @package TQ\tests\unit\cases
 */
class FormatterTest extends TestCase
{

    public function testMain()
    {
        $this->assertEquals('Wednesday, March 16, 2016 at 9:41:43 PM GMT+03:00', Formatter::get()->format(1458153703));
    }
}