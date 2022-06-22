<?php

function random_string(int $length) {
    $chars = 'abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'1234567890'
            .'!"$%^&*()-=_+#~[]{};:@|`?,.<>';
    $chars_max_index = mb_strlen($chars, 'ascii');
    
    $string = '';
    for($counter = 0; $counter < $length; $counter++) {
        $string .= $chars[random_int(0, $chars_max_index-1)];
    }
    return $string;
}

echo 'Installing...'."\n";

/**
 * This script needs to:
 * - connect to the mysql server and configure a new database with username and password
 * - store the password in a config file that we can use for connecting to the database later
 * - ...
 */

$db = new PDO('mysql:host=bugr-mysql', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

# Create database is we need to
$databases = array_column($db->query('SHOW DATABASES')->fetchAll(), 'Database');
if(!in_array('bugr', $databases)) {
    echo "Creating bug tracker database\n";
    $db->query('CREATE DATABASE bugr');
}

$user_exists = (bool) $db->query('SELECT 1 FROM mysql.user WHERE user = "bugr"')->rowCount();
if($user_exists === false) {
    echo "Creating database access credentials\n";
    # Create username/password with basic access
    $password = random_string(64);
    $db->query("CREATE USER IF NOT EXISTS bugr IDENTIFIED BY '$password'");
    $db->query("GRANT select,insert,update ON bugr.* TO bugr");

    # Store password in php config
    file_put_contents(__DIR__.'/resources/database_password', $password);
}

# From now on we can use the bugr database for queries
$db->query('USE bugr');

# Create tables by importing database migrations
$migrations_dir = __DIR__.'/resources/migrations';
$migrations = scandir($migrations_dir);
foreach($migrations as $migration) {
    if ($migration[0] === '.') continue;

    echo "Importing migration $migration\n";
    $sql = include $migrations_dir."/$migration";
    $db->query($sql);
}
