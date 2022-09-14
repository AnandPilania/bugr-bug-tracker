<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.projects (
        id int not null auto_increment,
        title varchar(50) not null,
        deleted int(1) not null default 0,
        primary key (id)
    )

SQL;