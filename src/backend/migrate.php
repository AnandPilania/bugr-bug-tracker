<?php

$db = new PDO('mysql:host=trackr-mysql', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

echo "Running migrations\n";

# Create tables by importing database migrations
$migrations_dir = __DIR__ . '/resources/migrations';

$migrations = scandir($migrations_dir);
sort($migrations);

foreach($migrations as $migration) {
    if ($migration[0] === '.') continue;
    if (!str_ends_with($migration, '.php')) continue;

    $pretty_name = substr($migration, 4);

    echo "Importing migration $pretty_name\n";
    $sql = include "$migrations_dir/$migration";

    try {
        $db->query($sql);
    }
    catch (PDOException $e) {
        // The main things we'll see here are duplicate columns so we can ignore them
        if (str_contains($e->getMessage(), 'Duplicate column')) continue;

        echo "> {$e->getMessage()}\n";
    }
}

echo "Done\n";
