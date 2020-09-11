<?php 
namespace TableCreator\Src;

use TableCreator\System\DatabaseConnector as SystemDatabaseConnector;

/**
 * Vytvarac SQL tabuliek
 * 
 * @var integer $integer
 * @method public integer 
 * - vklada 'integer', ak je zadany nazov "id" primarny index bude tento\
 * a AUTO_INCREMENT
 * @method public tinyint
 * @method public string - vklada varchar(255) s preddefinovanou dlzkou 255 a hodnotou NULL
 * @method public longtext
 * @method public timestamp - casovy odtlacok s preddefinovanou hodnotou CURRENT_TIMESTAMP
 * @method public decimal - cislo s plavajucou desatinnou ciarkou, pokial nema zadane\ 
 * defaultnu dlzku do funkcie, predvolena je 10,2 a hodnota je NULL
 * @method public primary
 * @method public unique
 * @method public indexes
 * *napr.:* fulltext index
 */
class TableCreator 
{

    /** @var array $integer */
    public $integer;
    /** @var float $float */
    public $float;
    /** @var bool $integer_primary - primary index */
    public $integer_primary;
    /** @var array $bigint */
    public $biginteger;
    /** @var array $tinyint */
    public $tinyint;
    /** @var array $string */
    public $string;
    /** @var array $text */
    public $text;
    /** @var array $longtext */
    public $longtext;
    /** @var array $timestamp */
    public $timestamp;
    /** @var array $decimal */
    public $decimal;
    /** @var array $primary */
    public $primary;
    /** @var array $unique */
    public $unique;
    /** @var array $table */
    public $table;
    /** @var array $indexes */
    public $indexes;
    /** @var array $indexes_val */
    public $indexes_val;
    /** @var array $timestamp_ou */
    public $timestamp_ou;
    /** @var array $biginteger_dl - default length */
    public $biginteger_dl;
    /** @var array $tinyint_dl - default length */
    public $tinyint_dl;
    /** @var array $string_dl - default length */
    public $string_dl;
    /** @var array $text_dl - default length */
    public $text_dl;
    /** @var array $decimals_dl - default length */
    public $decimals_dl;
    /** @var array $integer_dl - default length */
    public $integer_dl;
    /** @var array $biginteger_dv - default values */
    public $biginteger_dv;
    /** @var array $tinyint_dv - default values */
    public $tinyint_dv;
    /** @var array $text_dv - default values */
    public $text_dv;
    /** @var array $integer_dv - default values */
    public $integer_dv;
    /** @var array $timestamp_dv - default values */
    public $timestamp_dv;

    protected $dbConnection;

    function __construct( $table )
    {
        $this->table = $table;

        $this->dbConnection = (new SystemDatabaseConnector())->getConnection();
    }

    /**
     * @param string $integer column name
     * @param int $default_length default length
     * @param string $default_value default value
     * @param bool $primary - primary index default false
     * 
     * @return void
     */
    function integer( string $integer, int $default_length = 11, string $default_value = '', bool $primary = false )
    {
        $this->integer[] = $integer;
        $this->integer_dl[] = (int)$default_length;
        $this->integer_dv[] = (string)$default_value;
        $this->integer_primary[] = (bool)$primary;
    }

    /**
     * @param string $integer column name
     * @param string $default_value default value
     * 
     * @return void
     */
    function float( string $integer, string $default_value = '' )
    {
        $this->float[] = $integer;
        $this->integer_dv[] = (string)$default_value;
    }

    /**
     * @param string $integer column name
     * @param int $default_length default length
     * 
     * @return void
     */
    function tinyint( string $integer, int $default_dl = 1, $default_dv = 0 ){
        $this->tinyint[] = $integer;
        $this->tinyint_dl[] = (int)$default_dl;
        $this->tinyint_dv[] = (int)$default_dv;
    }

    /**
     * @param string $integer column name
     * @param int $default_length default length
     * @param string $default_value default value
     * 
     * @return void
     */
    function biginteger( string $integer, int $default_length = 20, string $default_value = '' )
    {
        $this->biginteger[] = $integer;
        $this->biginteger_dl[] = (int)$default_length;
        $this->biginteger_dv[] = (string)$default_value;
    }

    /**
     * @param string $string column name
     * @param int $default_length default length
     * 
     * @return void
     */
    function string( string $string, int $default_length = 255 )
    {
        $this->string[] = $string;
        $this->string_dl[] = (int)$default_length;
    }

    /**
     * @param string $text column name
     * 
     * @return void
     */
    function text( string $text )
    {
        $this->text[] = $text;
    }

    /**
     * @param string $longtext column name
     * 
     * @return void
     */
    function longtext( string $longtext )
    {
        $this->longtext[] = $longtext;
    }

    /**
     * @param string $timestamp column name
     * @param bool $default_val default value
     * @param string $on_update **!** only one column can be current_timestamp on update
     */
    function timestamp( string $timestamp, bool $default_val = false, bool $on_update = false )
    {
        $this->timestamp[] = $timestamp;
        $this->timestamp_dv[] = $default_val;
        $this->timestamp_ou[] = $on_update;
    }

    /**
     * @param string $decimal column name
     * @param string $default_length default length
     */
    function decimal( string $decimal, string $default_length = '10,2' )
    {
        $this->decimal[] = $decimal;
        $this->decimals_dl[] = $default_length;
    }

    /**
     * @param string $primary index name
     */
    function primary( string $primary )
    {
        $this->primary = $primary;
    }

    /**
     * @param string $unique index name
     */
    function unique( string $unique )
    {
        $this->unique = $unique;
    }

    /**
     * @param array $indexes index names
     * @param array $values index values
     */
    function indexes( array $indexes, array $values )
    {
        $this->indexes = $indexes;
        $this->indexes_val = $values;
    }

    /**
     * Create a query 
     */
    protected function build()
    {
        $sql = [];
        if( isset( $this->integer ) && !empty( $this->integer ) ){
            foreach( $this->integer as $key => $integer ):
                if( $integer === 'id' && $this->integer_primary[ $key ] === TRUE ): 
                    $sql[] = "`{$integer}` int(11) NOT NULL AUTO_INCREMENT";
                else: 
                    $integer_val = "`{$integer}` int(" . $this->integer_dl[$key] . ")";
                    if( !empty($this->integer_dv[$key]) && $this->integer_dv[$key] !== '' ) $integer_val .= " NOT NULL DEFAULT " . $this->integer_dv[$key];
                    else $integer_val .= " NULL DEFAULT NULL";
                    $sql[] = $integer_val;
                endif;
            endforeach;
        }

        if( isset( $this->float ) && !empty( $this->float ) ){
            foreach( $this->float as $key => $float ):
                $float_val = "`{$float}` float";
                if(!empty($this->float_dv[$key]) && $this->float_dv[$key] !== '' ) $float_val .= " NOT NULL DEFAULT " . $this->float_dv[$key];
                else $float_val .= " NULL DEFAULT NULL";
                $sql[] = $float_val;
            endforeach;
        }

        if( isset( $this->biginteger ) && !empty( $this->biginteger ) ){
            foreach( $this->biginteger as $key => $biginteger ):
                $bigint_val = "`{$biginteger}` bigint({$this->biginteger_dl[$key]})";
                if(!empty($this->biginteger_dv[$key]) && $this->biginteger_dv[$key] !== '' ) $bigint_val .= " NOT NULL DEFAULT " . $this->biginteger_dv[$key];
                else $bigint_val .= " NULL DEFAULT NULL";
                $sql[] = $bigint_val;
            endforeach;
        }
        
        if( isset( $this->string ) && !empty( $this->string ) ){
            foreach( $this->string as $key => $string ){
                $sql[] = "`{$string}` varchar({$this->string_dl[$key]}) NULL DEFAULT NULL";
            }
        }

        if( isset( $this->longtext ) && !empty( $this->longtext ) ){
            foreach( $this->longtext as $longtext ):
                $sql[] = "`{$longtext}` longtext NULL DEFAULT NULL";
            endforeach;
        }

        if( isset( $this->text ) && !empty( $this->text ) ){
            foreach( $this->text as $text ):
                $sql[] = "`{$text}` text NULL DEFAULT NULL";
            endforeach;
        }

        if( isset( $this->timestamp ) && !empty( $this->timestamp ) ){
            foreach( $this->timestamp as $key => $timestamp ):
                $time = "`{$timestamp}` timestamp";
                if( $this->timestamp_dv[$key] !== true ) $time .= " NULL DEFAULT NULL";
                else $time .= " NULL DEFAULT CURRENT_TIMESTAMP";
                if( $this->timestamp_dv[$key] && $this->timestamp_ou[$key] ) $time .= " ON UPDATE CURRENT_TIMESTAMP";
                $sql[] = $time;
            endforeach;
        }
        if( isset( $this->decimal ) && !empty( $this->decimal ) ){
            foreach( $this->decimal as $key => $decimal ):
                $value = "`{$decimal}` ";
                $value .= "decimal({$this->decimals_dl[$key]})";
                $value .= " NULL DEFAULT NULL";

                $sql[] = $value;
            endforeach;
        }

        if( isset( $this->tinyint ) && !empty($this->tinyint) ){
            foreach( $this->tinyint as $key => $tinyint ):
                $value = "`{$tinyint}` tinyint( {$this->tinyint_dl[$key]} )";
                if( $this->tinyint_dv[$key] == 0 )
                    $value .= "NULL DEFAULT NULL";
                else $value .= "NOT NULL DEFAULT " . $this->tinyint_dv[$key];

                $sql[] = $value;
            endforeach;
        }

        if( isset( $this->integer ) && $this->integer[0] == 'id' && $this->integer_primary[0] === TRUE && !isset( $this->primary ) ){
            $sql[] = "PRIMARY KEY (`id`)";
        } else if( isset( $this->primary ) ){
            $sql[] = "PRIMARY KEY (`{$this->primary}`)";
        }

        if( $this->indexes && !empty( $this->indexes ) )
        {
            foreach( $this->indexes as $key => $index  ):
                $sql[] = strtoupper( $index ) . " KEY (" . $this->indexes_val[$key] . ")";
            endforeach;
        }

        return implode(',', $sql);
    }

    /**
     * execute query
     */
    function up()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `$this->table` ( " . $this->build() . " ) ENGINE = InnoDB DEFAULT CHARSET = utf8 DEFAULT COLLATE utf8_general_ci";

            $this->dbConnection->exec( $sql );

        } catch( \PDOException $e )
        {
            exit( $e->getMessage() );
        }
    }

    /** 
     * seed the created tables 
     * @param string $seeding_values
     * 
     * @return void
     */
    function seed( string $seeding_values )
    {
        if( empty( $this->dbConnection->query("SELECT * FROM {$this->table} WHERE 1")->fetch() ) ){
            $create = new TableSeeder( $this->table );
            $create->seed( $seeding_values );
        }
    }

}