<?php

namespace TableCreator\Src;

use TableCreator\System\DatabaseConnector as SystemDatabaseConnector;

class TableSeeder 
{
    private $data;

    protected $table;
    protected $dbConnection;

    function __construct( string $table )
    {
        $this->table = $table;

        $this->dbConnection = (new SystemDatabaseConnector())->getConnection();
    }
 
    public function seed( $seeding_values )
    {

        $sql = "INSERT INTO {$this->table} ";

        // $sql .= '(' . implode(',', \array_keys( $seeding_values ) ) . ')';
        
        $sql .= "(";
        $sql .= implode( ",", array_keys( $seeding_values[0] ) );
        $sql .= ")";

        $sql .= ' VALUES '; $i = 1;
        
        foreach( $seeding_values as $string )
        {
            $int = 1;
            $sql .= "(";
            foreach( $string as $key => $value )
            {
                $sql .= "'$value'";

                if( $int < count( $string ) ) $sql .= ','; $int++;
                
            }
            $sql .= ")";

            if( $i < count( $seeding_values ) ) $sql .= ','; $i++;
            
        }
        

        try
        {
            $this->dbConnection->exec( $sql );
        } 
        catch( \Exception $e )
        {
            exit( $e->getMessage() );
        }
    }
}