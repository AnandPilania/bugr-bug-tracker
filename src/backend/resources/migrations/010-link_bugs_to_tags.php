<?php
return <<<SQL

    CREATE TABLE IF NOT EXISTS trackr.bug_tags (
        bug_id int not null,
        tag_id int not null,
        key(bug_id),
        key(tag_id)
    )

SQL;