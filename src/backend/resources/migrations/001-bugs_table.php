<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS bugs (
        id int not null auto_increment,
        title varchar(50) not null,
        content text null,
        primary key (id)
    )

SQL;