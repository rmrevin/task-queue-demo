<?php
/**
 * bootstrap.php
 * @author Revin Roman
 */

$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../../vendor/autoload.php');

//define('PDO_DSN', 'sqlite::memory:');
define('PDO_DSN', sprintf('sqlite:%s/runtime/task.sq3', __DIR__));
define('PDO_USER', null);
define('PDO_PASS', null);

define('TIMEZONE', 'Etc/GMT-3');

require_once(__DIR__ . '/TestCase.php');
