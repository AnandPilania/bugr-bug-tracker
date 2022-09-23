<?php
return <<<SQL

    ALTER TABLE trackr.statuses ADD COLUMN
        priority int default 0 not null

SQL;