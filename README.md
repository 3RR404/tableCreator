# tableCreator
 Create the table onload the page

## Use

- load the database
```
require_once "Database.php";
```

- load the creator
```
require_once "TableCreator.php";
```

- use in class
```php
use App\TableCreator;

$table = new TableCreator( 'mytable' );
$table->integer('id', 11, '', true );
$table->up();
$table->seed();
```
create table with name **'mytable'** $table = new TableCreator( 'mytable' );
This create only one column with name **id**, that will be integer type 11 lengt with default value '' and AUTO_INCREMENT PRIMARY key

up() method execute the prepared SQL.

```php
$table = new TableCreator( 'mytable' );
$table->integer('id', 11, '', true );
$table->string('name' );
$table->string('description' );
$table->up();
$table->seed( 'test' );
```

$table->seed( 'test' ); insert into table data from TableSeeder array with key 'test'. 

TRY Have Fun. No 3RR-ors