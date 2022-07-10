<?php

namespace BugTracker\Factory;

use SourcePot\Core\Config\Config;
use SourcePot\Factory\FactoryInterface;
use SourcePot\Persistence\DatabaseAdapter;

class DatabaseAdapterFactory implements FactoryInterface
{
    public function __construct(
        private Config $config
    ) {
    }

    public function build(...$args): object
    {
        $host = $this->config->get('database.host');
        $username = $this->config->get('database.credentials.username');
        $password = file_get_contents(ROOT_DIR.'/'.$this->config->get('database.credentials.password-file'));
        $dbname = $this->config->get('database.database');

        $database = new DatabaseAdapter;
        $database->setup($host);
        $database->connect($username, $password, $dbname);

        return $database;
    }
}
