<?php

namespace App;

class Database extends \PDO
{
    public $connectionData = array();

    private function getConnectionString( \stdClass $connectionData) {
        $connectionString = "{$connectionData->lib}";

        if(isset($connectionData->socket))   $connectionString .= ":unix_socket={$connectionData->socket};";
        elseif(isset($connectionData->host)) $connectionString .= ":host={$connectionData->host};";
        if(isset($connectionData->port))     $connectionString .= "port={$connectionData->port};";
        if(isset($connectionData->dbname)) $connectionString .= "dbname={$connectionData->dbname}";

        return $connectionString;
    }

    function __construct(array $connectionData) {
        $cd = (object)$connectionData;
        if(!isset($cd->charset)) $cd->charset = 'utf8';

        $connectionString = $this->getConnectionString($cd);
        $this->connectionData['string'] = $connectionString;
        $this->connectionData['user'] = $cd->user;
        $this->connectionData['password'] = $cd->password;

        parent::__construct($connectionString, $cd->user, $cd->password, array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$cd->charset}"
        ));
    }
}

final class Db
{
    static private $dbPDO;
	static private $db;

	static function connect() {
		self::$dbPDO = new Database( [ 'user' => 'rooter', 'password' => '', 'host' => 'localhost', 'dbname' => 'test', 'lib' => 'mysql' ] );
		self::$dbPDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$db = self::$dbPDO;
	}

	static function get() {
		return self::$db;
	}

	static function getPDO() {
		return self::$dbPDO;
	}
}