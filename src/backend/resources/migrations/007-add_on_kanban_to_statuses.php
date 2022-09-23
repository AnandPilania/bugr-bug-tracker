<?php
return <<<SQL

    ALTER TABLE trackr.statuses ADD COLUMN
        on_kanban tinyint(1) default 1 not null

SQL;