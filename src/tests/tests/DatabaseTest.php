<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Core\Persistence\MySQLDatabase as Database;
use SourcePot\Core\Storage\Storage;
use SourcePot\IO\FileLoader;

final class DatabaseTest extends TestCase
{
    private Database $database;

    protected function setup(): void
    {
        $this->assertTrue(class_exists(Database::class));
        Storage::setFromJson(
            FileLoader::loadJsonFromFile('config.json')
        );
    }

    private function dbConnect(): void
    {
        $this->database = new Database(
            Storage::get('database.hostname'),
            Storage::get('database.credentials.username'),
            Storage::get('database.credentials.password'),
            Storage::get('database.database')
        );
    }

    public function testCanInstantiateDatabaseObject(): void
    {
        $database = new Database(
            Storage::get('database.hostname'),
            Storage::get('database.credentials.username'),
            Storage::get('database.credentials.password'),
            Storage::get('database.database')
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
