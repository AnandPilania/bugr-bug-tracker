<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.statuses (
        id int not null auto_increment,
        title varchar(50) not null,
        project_id int not null,
        primary key (id)
    )

SQL;