<?php

use SourcePot\Autoloader;
use SourcePot\Container\Container;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Core;
use SourcePot\IO\FileLoader;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/resources/lib/SourcePot/Autoloader.php';
Autoloader::register();

// @todo extract this to some CORS module to automatically add the CORS headers
// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE');
header('Access-Control-Allow-Headers: content-type,token');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   http_response_code(204);
   exit;
}

$core = new Core();
$core->loadConfig(dirname(__DIR__) . '/config.json');
$core->execute();
