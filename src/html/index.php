<?php

use SourcePot\Core\Core;
use SourcePot\Core\Config\StorageConfig as Config;
use SourcePot\Core\Storage\Storage;
use SourcePot\IO\FileLoader;

require dirname(__DIR__).'/resources/lib/autoloader.php';

$config = new Config();
$config->load(FileLoader::loadJsonFromFile(dirname($_SERVER['DOCUMENT_ROOT']).'/config.json'),true);

$core = new Core($config);
$core->execute();

// $password = trim(file_get_contents(dirname(__DIR__).'/resources/database_password'));
// $db = new PDO('mysql:host=bugr-mysql', 'bugr', $password);
// $db->query('USE bugr');
// var_dump($db->query('SHOW TABLES')->fetchAll());

// phpinfo();