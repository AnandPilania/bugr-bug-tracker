<?php

namespace SourcePot\Model;

use SourcePot\Core\Persistence\MySQLDatabase as Database;

class Bug extends AbstractModel
{
    public function save(Database $database): bool
    {
        if(isset($this->data['id'])) {
            // update
            $stmt = $database->prepare('UPDATE bug SET title = :title, content = :content WHERE id = :id');
            $stmt->execute($this->data);
            return true;
        }

        // insert
        $stmt = $database->prepare('INSERT INTO bug SET title = :title, content = :content');
        $stmt->execute($this->data);
        $id = $database->lastInsertId();
        if($id) {
            $this->data['id'] = $id;
            return true;
        }
        return false;
    }

    public static function createFromExisting(Database $database, int $id): static
    {
        $stmt = $database->prepare('SELECT * FROM bug WHERE id = :id');
        $stmt->execute([
            'id' => $id
        ]);
        return static::create($stmt->fetch());
    }
}