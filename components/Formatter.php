<?php
/**
 * Formatter.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\components;

use IntlDateFormatter;

/**
 * Class Formatter
 * @package Plp\components
 */
class Formatter
{

    /**
     * @return IntlDateFormatter
     */
    public static function get()
    {
        return new IntlDateFormatter(
            'en_US',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            TIMEZONE,
            IntlDateFormatter::GREGORIAN
        );
    }

    /**
     * @param integer|bool $time
     * @return string
     */
    public static function databaseTime($time = false)
    {
        $time = empty($time) ? time() : $time;

        $date = (new \DateTime())
            ->setTimestamp($time)
            ->setTimezone(new \DateTimeZone(TIMEZONE));

        return static::get()->formatObject($date, 'Y-MM-dd HH:mm:ss');
    }
}