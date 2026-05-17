<?php
    class AdminService
    {
        private PDO $db;

        public function __construct(PDO $db)
        {
            $this->db = $db;
        }
    }

?>