<?php

use PHPUnit\Framework\TestCase;
use BugTracker\Core\Persistence\MySQLDatabase as Database;
use SourcePot\Storage\Storage;
use SourcePot\IO\FileLoader;

final class DatabaseTest extends TestCase
{
    private Database $database;
    private Storage $storage;

    protected function setup(): void
    {
        $this->assertTrue(class_exists(Database::class));
        $this->storage = Storage::create();
        $this->storage->loadFromJson(
            FileLoader::loadJsonFromFile('config.json')
        );
    }

    private function dbConnect(): void
    {
        $this->database = new Database(
            $this->storage->get('database.hostname'),
            $this->storage->get('database.credentials.username'),
            $this->storage->get('database.credentials.password'),
            $this->storage->get('database.database')
        );
    }

    public function testCanInstantiateDatabaseObject(): void
    {
        $database = new Database(
            $this->storage->get('database.hostname'),
            $this->storage->get('database.credentials.username'),
            $this->storage->get('database.credentials.password'),
            $this->storage->get('database.database')
        );
        $this->assertInstanceOf(
            Database::class,
            $database
        );
    }

    public function testCanRunSelectQuery(): void
    {
        $this->dbConnect();
        $query = 'SHOW TABLES';
        $rslt = $this->database->query($query);
        $this->assertNotNull($rslt);
    }
}
