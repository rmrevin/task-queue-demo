<?php
/**
 * Config.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace TQ\components;

/**
 * Class Config
 * @package TQ\components
 */
class Config
{

    static $data;

    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        static::load();

        return empty($key) ? static::$data : (isset(static::$data[$key]) ? static::$data[$key] : $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        static::load();

        static::$data[$key] = $value;
    }

    public static function load()
    {
        if (empty(static::$data)) {
            static::$data = require_once __DIR__ . '/../config.php';
        }
    }
}