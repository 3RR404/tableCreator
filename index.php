<?php

echo 'Hello i-m Table Creator';

require_once "Database.php";
require_once "TableCreator.php";

/**
 * ## Containing in context of string
 * @param string $string where to finding
 * @param string $find finding string
 * 
 * @return bool
 */
function contains($string, $find) {
    return @strpos($string, $find) !== false;
}

use App\TableCreator;

$table = new TableCreator( 'mytable2' );
$table->integer('id', 11, '', true );
$table->string('name' );
$table->string('description' );
$table->up();
$table->seed( 'test' );