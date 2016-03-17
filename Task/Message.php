<?php
/**
 * Message.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\Task;

/**
 * Class Message
 * @package Plp\Task
 */
class Message extends AbstractTask
{

    /**
     * @param mixed $data
     * @return string
     */
    public static function sms($data)
    {
        return __METHOD__ . PHP_EOL . print_r($data, 1);
    }
}