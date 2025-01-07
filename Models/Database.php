<?php

class Database {
    protected static $_dbInstance = null;
    
    protected $_dbHandle;

    /**
     * Establish database connection
     * @return Database|null
     */
    public static function getInstance() {

        $host= 'poseidon.salford.ac.uk';
        $dbName = 'age806';
        $user = 'age806';
        $pass = 'gk3SX9PK43r6Ily';

        if(self::$_dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self($user, $pass, $host, $dbName);
        }
        
        return self::$_dbInstance;
    }

    /** Creating the PDO handle
     * @param string $username
     * @param string $password
     * @param string $host
     * @param string $database
     * @throws PDOException $e
     */
    private function __construct($username, $password, $host, $database) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database",  $username, $password);


        }
        catch (PDOException $e) { 
            echo $e->getMessage();
        }
    }

    /**
     * Get Database handle
     * @return PDO
     */
    public function getDbConnection() {
        return $this->_dbHandle;                                   
    }

    /**
     * End database connection
     */
    public function __destruct() {
        $this->_dbHandle = null;
    }
}
 