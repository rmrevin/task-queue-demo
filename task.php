<?php
/**
 * task.php
 * @author Revin Roman
 */

use Aura\Cli\CliFactory;
use Aura\Cli\Status;
use Plp\controllers\NextTaskController;

require_once __DIR__ . '/vendor/autoload.php';

$cli_factory = new CliFactory;
$stdio = $cli_factory->newStdio();

if (!file_exists(__DIR__ . '/.env.php')) {
    $stdio->errln('Environment configuration file `.env.php` not created.');

    exit(Status::FAILURE);
}

require_once __DIR__ . '/.env.php';

while (true) {
    try {
        $Controller = new NextTaskController;
        $Controller->stdio = $stdio;

        $Controller->run();
    } catch (RuntimeException $e) {
        $stdio->errln($e->getMessage());
    }
}
