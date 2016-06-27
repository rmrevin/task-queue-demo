<?php
/**
 * Integration.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\Task;

/**
 * Class Integration
 * @package TQ\Task
 */
class Integration extends AbstractTask
{

    /**
     * @param mixed $data
     * @return string
     */
    public static function process($data)
    {
        return __METHOD__ . PHP_EOL . print_r($data, 1);
    }
}