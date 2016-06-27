<?php
/**
 * Account.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\Task;

/**
 * Class Account
 * @package TQ\Task
 */
class Account extends AbstractTask
{

    /**
     * @param mixed $data
     * @return string
     */
    public static function bill($data)
    {
        return __METHOD__ . PHP_EOL . print_r($data, 1);
    }
}