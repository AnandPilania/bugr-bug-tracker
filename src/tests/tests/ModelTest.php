<?php

use PHPUnit\Framework\TestCase;
use SourcePot\Model\AbstractModel;
use SourcePot\Model\Bug;
use SourcePot\IO\FileLoader;
use BugTracker\Core\Persistence\MySQLDatabase as Database;
use SourcePot\Storage\Storage;

final class ModelTest extends TestCase
{
    public function testCannotInstantiateAbstractModelClass(): void
    {
        $this->expectException(\Error::class);
        new AbstractModel();
    }

    public function testCannotInstantiateBugClass(): void
    {
        $this->expectException(\Error::class);
        new Bug;
    }

    public function testCanUseCreateMethodOfBugModelWithData(): void
    {
        $bug = Bug::create([
            'id' => 3,
            'title' => 'this is a bug'
        ]);
        $this->assertInstanceOf(
            Bug::class,
            $bug
        );
    }

    public function testCanGetDataFromBugModel(): void
    {
        $title = 'bug title';

        $bug = Bug::create([
            'id' => 3,
            'title' => $title
        ]);

        $this->assertEquals(
            $title,
            $bug->get('title')
        );
    }

    public function testCanSaveBugToDatabase(): void
    {
        $bug = Bug::create([
            'title' => 'New bug',
            'content' => 'This describes the bug in question'
        ]);

        $storage = Storage::create();
        $storage->loadFromJson(FileLoader::loadJsonFromFile('config.json'));
        $database = new Database(
            username: $storage->get('database.credentials.username'),
            password: $storage->get('database.credentials.password'),
            database: $storage->get('database.database'),
            host: $storage->get('database.hostname')
        );

        $this->assertTrue($bug->save($database));
    }

    public function testCanLoadBugFromDatabase(): void
    {
        $storage = Storage::create();
        $storage->loadFromJson(FileLoader::loadJsonFromFile('config.json'));
        $database = new Database(
            username: $storage->get('database.credentials.username'),
            password: $storage->get('database.credentials.password'),
            database: $storage->get('database.database'),
            host: $storage->get('database.hostname')
        );

        $id = 1;

        $bug = Bug::createFromExisting($database, $id);

        $this->assertInstanceOf(Bug::class, $bug);
        $this->assertEquals($id, $bug->get('id'));
    }

    public function testCanSaveExitingBugToDatabase(): void
    {
        $storage = Storage::create();
        $storage->loadFromJson(FileLoader::loadJsonFromFile('config.json'));
        $database = new Database(
            username: $storage->get('database.credentials.username'),
            password: $storage->get('database.credentials.password'),
            database: $storage->get('database.database'),
            host: $storage->get('database.hostname')
        );

        $id = 1;
        $field = 'title';
        $newValue = 'updated bug';

        $bug = Bug::createFromExisting($database, $id);
        $bug->set($field, $newValue);

        $this->assertTrue($bug->save($database));

        $bug = Bug::createFromExisting($database, $id);

        $this->assertEquals($newValue, $bug->get($field));
    }
}
