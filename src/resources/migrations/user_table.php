<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS user (
        id int not null auto_increment,
        username varchar(50) not null,
        password varchar(255) not null,
        active int(1) not null default 0,
        primary key (id)
    )

SQL;