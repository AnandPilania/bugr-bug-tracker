<?php
return <<<SQL

    ALTER TABLE trackr.users
    ADD COLUMN is_admin INT(1) DEFAULT 0

SQL;
