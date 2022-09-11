# Trackr database migrations
> Rules for creating migrations

1. All migrations must be named with as follows:
   1. 3 digit number so all migrations are correctly ordered
   2. A hyphen
   3. A description of the change in snake case
   4. The `.php` extension
   
   Example: `000-create_database.php`
2. Each migration must be idempotent: If a migration is run multiple times, the same outcome is expected at the end of each run.
3. Migrations can depend on previous migrations, but (obviously) not future migrations.
4. Once a migration has been committed, it must not be changed.  A further migration must be created that amends the previous changes.
5. Migrations must use the database name as it is not guaranteed that a `use` statement has been run in advance.
6. Each migration is a MySQL statement wrapped in a return statement.  The migrations are applied by `include`ing each file to capture it's return value, then run on the database.
