<?php
    
    class Database
    {
        // private $host;
        // private $dbname;
        // private $username;
        // private $password;
        // private $obj;
        private static $connection = null;
        


        private function __construct()
        {

        }

        public static function getConnection()
        {
            $config = require __DIR__ . '/../config.php';

            try {
                if(self::$connection === null) {
                $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'] . ";charset=utf8mb4";
                self::$connection = new PDO($dsn, $config['username'], $config['password']);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
                return self::$connection;
            } catch(PDOException $error) {
                die("Connection failed: " . $error->getMessage());
                
            }
        }
    }

    

?>