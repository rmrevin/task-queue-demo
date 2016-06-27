<?php
/**
 * TestIO.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\tests\unit\components;

use Aura\Cli\Stdio;

/**
 * Class TestIO
 * @package TQ\tests\unit\components
 */
class TestIO
{

    /** @var string */
    public $stdout = '';

    /**
     * @param string $message
     */
    public function out($message)
    {
        $this->stdout .= $message;
    }

    /**
     * @param string $message
     */
    public function outln($message)
    {
        $this->stdout .= $message . PHP_EOL;
    }

    public function flush()
    {
        $this->stdout = '';
    }
}