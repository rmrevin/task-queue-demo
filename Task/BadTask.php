<?php
/**
 * BadTask.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\Task;

/**
 * Class BadTask
 * @package TQ\Task
 */
class BadTask extends AbstractTask
{

    public static function user()
    {
        throw new UserException('User bad task');
    }

    public static function fatal()
    {
        throw new FatalException('Fatal bad task');
    }

    public static function exception()
    {
        throw new \Exception('Exception bad task');
    }
}