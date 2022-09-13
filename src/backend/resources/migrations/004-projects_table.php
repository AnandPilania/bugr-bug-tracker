<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.projects (
        id int not null auto_increment,
        title varchar(50) not null,
        primary key (id)
    )

SQL;