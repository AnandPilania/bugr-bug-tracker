<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.bugs (
        id int not null auto_increment,
        title varchar(50) not null,
        description text null,
        status_id int not null,
        project_id int not null,
        assignee_id int default null,
        primary key (id)
    )

SQL;