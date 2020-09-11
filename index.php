<?php

require_once __DIR__ . "/vendor/autoload.php";

use TableCreator\Src\TableSeeder;
use TableCreator\Src\TableCreator;

echo 'Hello i-m Table Creator';

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

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$table = new TableCreator( 'mytable3' );
$table->integer('id', 11, '', true );
$table->string('name' );
$table->longtext('description' );
$table->up();


$values = [
    [
        'id' => 1,
        'name' => 'Post test number one',
        'description' => 'Consequat laboris dolor dolor aliquip veniam. Reprehenderit exercitation reprehenderit proident ullamco.Velit sint est in incididunt est aliqua voluptate est deserunt reprehenderit. Irure esse magna excepteur eiusmod. Laboris elit commodo est non pariatur consectetur. Laboris ex et consequat eiusmod id quis in aliquip eu do aliqua labore incididunt nulla. Minim elit consectetur elit ea tempor sit culpa Lorem Lorem. Nulla tempor eu deserunt adipisicing anim ad reprehenderit. Occaecat ipsum aliquip deserunt proident non et magna quis magna sint. Dolore anim qui reprehenderit veniam dolore elit culpa ex consectetur duis ad. Voluptate nulla esse magna culpa reprehenderit ut fugiat est sint elit enim nisi.',
    ],
    [
        'id' => 2,
        'name' => 'Post test number two',
        'description' => 'Ipsum minim cillum ut et sit ad sit pariatur Lorem. Duis fugiat nulla id consectetur sit quis esse id nulla mollit eiusmod adipisicing tempor duis.',
    ]
];

$seed = (new TableSeeder( 'mytable3' ))->seed( $values );