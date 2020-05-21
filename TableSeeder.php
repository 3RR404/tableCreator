<?php

namespace App;

class TableSeeder 
{
    private $data;
    protected $table;

    function __construct( string $table )
    {
        $this->table = $table;
    }

    protected function getData()
    {
        $data_array = [
            'test' => [
                'id' => 1,
                'name' => 'My first test',
                'description' => 'Lorem Ipsum sit Dolor amet...'
            ]
        ];

        return $data_array;
    }
    
    public function seed( $seed_string = false )
    {
        $this->data = $this->getData()[ $seed_string ];

        $sql = "INSERT INTO {$this->table} ";

        $sql .= '(' . implode(',', \array_keys( $this->data ) ) . ')';
        $sql .= ' VALUES ('; $i = 1;
        foreach( $this->data as $string )
        {
            $sql .= "'$string'";
            if( $i < count( $this->data ) ) $sql .= ','; $i++;
        }
        $sql .= ')';

        try{
            Db::getPDO()->query( $sql );
        } catch( \Exception $e )
        {
            echo $e->getMessage();
        }
    }
}