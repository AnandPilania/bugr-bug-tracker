<?php

use SourcePot\Core\Core;
use SourcePot\Core\Config\Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\IO\FileLoader;

require dirname(__DIR__).'/resources/lib/autoloader.php';

$config = new Config;
$config->setMany(FileLoader::loadJsonFromFile(dirname($_SERVER['DOCUMENT_ROOT']).'/config.json'),true);

$core = new Core($config);
$core->execute();
