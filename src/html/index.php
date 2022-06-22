<?php

require dirname(__DIR__).'/resources/lib/autoloader.php';

$core = SourcePot\Core\Core::create()->execute();

echo "\n\nAutoloaded classes:\n";
echo implode("\n", Autoloader::$loadedClasses);

// $password = trim(file_get_contents(dirname(__DIR__).'/resources/database_password'));
// $db = new PDO('mysql:host=bugr-mysql', 'bugr', $password);
// $db->query('USE bugr');
// var_dump($db->query('SHOW TABLES')->fetchAll());

// phpinfo();