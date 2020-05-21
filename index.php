<?php

echo 'Hello i-m Table Creator';

require_once "Database.php";
require_once "TableCreator.php";

use App\TableCreator;

$table = new TableCreator( 'mytable2' );
$table->integer('id', 11, '', true );
$table->string('name' );
$table->string('description' );
$table->up();
$table->seed( 'test' );