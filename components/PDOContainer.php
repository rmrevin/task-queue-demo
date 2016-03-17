<?php
/**
 * PDOContainer.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\components;

use Aura\Sql\ExtendedPdo;

/**
 * Class PDOContainer
 * @package Plp\components
 */
class PDOContainer
{

    static $instance = null;

    /**
     * @return ExtendedPdo|null
     */
    public static function get()
    {
        if (static::$instance === null) {
            static::$instance = new ExtendedPdo(PDO_DSN, PDO_USER, PDO_PASS);
        }

        return static::$instance;
    }
}