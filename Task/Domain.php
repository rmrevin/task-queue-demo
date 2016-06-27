<?php
/**
 * Domain.php
 * @author Revin Roman
 */

namespace TQ\Task;

/**
 * Class Domain
 * @package TQ\Task
 */
class Domain extends AbstractTask
{

    /**
     * @param mixed $data
     * @return string
     */
    public static function addzone($data)
    {
        return __METHOD__ . PHP_EOL . print_r($data, 1);
    }
}