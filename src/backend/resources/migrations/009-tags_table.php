<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.tags (
        id int not null auto_increment,
        title varchar(50) not null,
        project_id int not null,
        deleted int(1) not null default 0,
        primary key (id)
    )

SQL;