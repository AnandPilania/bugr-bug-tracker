<?php

use Error;
use PHPUnit\Framework\TestCase;
use SourcePot\Model\AbstractModel;
use SourcePot\Model\Bug;
use SourcePot\IO\FileLoader;
use SourcePot\Core\Persistence\MySQLDatabase as Database;
use SourcePot\Core\Storage\Storage;

final class ModelTest extends TestCase
{
    public function testCannotInstantiateAbstractModelClass(): void
    {
        $this->expectException(Error::class);
        new AbstractModel();
    }

    public function testCannotInstantiateBugClass(): void
    {
        $this->expectException(Error::class);
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

        Storage::setFromJson(FileLoader::loadJsonFromFile('config.json'));
        $database = new Database(
            username: Storage::get('database.credentials.username'),
            password: Storage::get('database.credentials.password'),
            database: Storage::get('database.database'),
            host: Storage::get('database.hostname')
        );

        $this->assertTrue($bug->save($database));
    }

    public function testCanLoadBugFromDatabase(): void
    {
        $database = new Database(
            username: Storage::get('database.credentials.username'),
            password: Storage::get('database.credentials.password'),
            database: Storage::get('database.database'),
            host: Storage::get('database.hostname')
        );

        $id = 1;

        $bug = Bug::createFromExisting($database, $id);

        $this->assertInstanceOf(Bug::class, $bug);
        $this->assertEquals($id, $bug->get('id'));
    }

    public function testCanSaveExitingBugToDatabase(): void
    {
        $database = new Database(
            username: Storage::get('database.credentials.username'),
            password: Storage::get('database.credentials.password'),
            database: Storage::get('database.database'),
            host: Storage::get('database.hostname')
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
