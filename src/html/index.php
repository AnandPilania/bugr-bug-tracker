<?php

// setup autoloader

// start the core

// tell core to execute request

$password = trim(file_get_contents(dirname(__DIR__).'/resources/database_password'));
$db = new PDO('mysql:host=bugr-mysql', 'bugr', $password);
$db->query('USE bugr');
var_dump($db->query('SHOW TABLES')->fetchAll());

// phpinfo();