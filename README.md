# tableCreator
 MySQL query-base table generator. Create the table onload the page. 
This app use PDO extension. 
 
## Use

- load the database 
```
require_once "DatabaseConnector.php";
```
 
All Database setings are in .env file example is in file index.php, or [on github page]{https://github.com/vlucas/phpdotenv}
 
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
```

```
(new TableSeeder( 'mytable' ))->seed( $values );
``` 
 
insert data from values variable into table. 
 
TRY Have Fun. No 3RR-ors
