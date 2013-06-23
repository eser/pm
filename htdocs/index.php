<?php

if (!file_exists($scabbiaLoader = __DIR__ . '/vendor/autoload.php')) {
    throw new RuntimeException('Unable to load Composer which is required for Scabbia Framework. Run `./composer_update.sh`.');
}

$loader = require($scabbiaLoader);

if (defined('SCABBIA_PATH') && SCABBIA_PATH !== false) {
    $loader->set('Scabbia', SCABBIA_PATH);
} elseif (file_exists($scabbiaPath = __DIR__ . '/../scabbia-dev/src')) {
    define('SCABBIA_PATH', $scabbiaPath);
    $loader->set('Scabbia', $scabbiaPath);
}

use Scabbia\Framework;

Framework::$development = true;
Framework::$disableCaches = true;
Framework::load($loader);

Framework::addApplication('App', 'application/');

Framework::run();
