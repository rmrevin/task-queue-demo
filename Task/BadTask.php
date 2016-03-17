<?php
/**
 * BadTask.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\Task;

/**
 * Class BadTask
 * @package Plp\Task
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
}