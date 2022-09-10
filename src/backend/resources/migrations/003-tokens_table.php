<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS tokens (
        id int not null auto_increment,
        user_id int not null,
        token varchar(255) not null,
        expiry datetime not null,
        primary key (id)
    )

SQL;
