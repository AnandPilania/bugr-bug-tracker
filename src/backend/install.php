<?php

function random_string(int $length): string {
    $chars = 'abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'1234567890'
            .'!"$%^&*()-=_+#~[]{};:@|`?,.<>';
    $chars_max_index = mb_strlen($chars, 'ascii');
    
    $string = '';
    $counter = 0;
    while($counter++ < $length) {
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

$db = new PDO('mysql:host=trackr-mysql', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$user_exists = (bool) $db->query('SELECT 1 FROM mysql.user WHERE user = "trackr"')->rowCount();
if($user_exists === false) {
    echo "Creating database access credentials\n";
    # Create username/password with basic access
    $password = random_string(64);
    $db->query("CREATE USER IF NOT EXISTS trackr IDENTIFIED BY '$password'");
    $db->query('GRANT select,insert,update ON trackr.* TO trackr');

    # Store password in php config
    file_put_contents(__DIR__ . '/resources/database_password', $password);
}

# Run migrations (this includes creating the database)
# Run this like an external program so I can also run it separately
$command = 'php ' . __DIR__ . '/migrate.php';
passthru($command);

