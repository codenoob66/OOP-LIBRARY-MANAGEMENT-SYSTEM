<?
    class Database
    {
        private $host;
        private $dbname;
        private $username;
        private $password;


        public function __construct($host, $dbname, $username, $password)
        {
            $this->host = $host;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->password = $password;
        }

        public function connect()
        {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4";
            
            return new PDO($dsn, $this->username, $this->password);
        }
    }

?>