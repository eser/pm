<?php

// if scabbia installation on different directory
// if (file_exists($scabbiaPath = __DIR__ . '/../scabbia-dev/src')) {
//     define('SCABBIA_PATH', $scabbiaPath);
// }

if (!file_exists($scabbiaLoader = 'vendor/autoload.php')) {
    throw new RuntimeException('Unable to load Scabbia Framework. Run `./composer_update.sh` or define a php constant named SCABBIA_PATH to locate the framework installation.');
}

$loader = require($scabbiaLoader);

if (defined('SCABBIA_PATH') && SCABBIA_PATH !== false) {
    $loader->set('Scabbia', SCABBIA_PATH);
}

use Scabbia\Framework;

Framework::$development = true;
Framework::load($loader);

Framework::runApplication('App');
