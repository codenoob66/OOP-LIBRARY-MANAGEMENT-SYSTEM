<?php
    class AuthService
    {
        private PDO $db;

        public function __construct(PDO $db)
        {
           $this->db = $db;
        }
        
        public function register(string $name, string $password): ?User
        {
            $stmt = $this->db->prepare(
                "SELECT COUNT (*) FROM user_tbl 
                WHERE name = :name"
            );

            $stmt->execute([
                ':name' => $name
            ]); 

            $count = $stmt->fetchColumn();

            if($count > 0) {
                return null;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);


            $stmt = $this->db->prepare(
                "INSERT INTO user_tbl (name, password)
                 VALUES (:name, :hash)"
            );
 
            $stmt->execute([
                ':name' => $name,
                ':hash' => $hash
            ]);

            $id = $this->db->lastInsertId();

            // this return null is to avoid vscode from screaming all paths dont return a value
            return new User($id, $name, $hash, 'user');
            
        }

        public function login(string $name, string $password): ?User
        {
            $stmt = $this->db->prepare(
                "SELECT id, name, password, role
                 FROM user_tbl
                 WHERE name = :name"
            );

            $stmt->execute([
                ':name' => $name
            ]);

            $row = $stmt->fetch();

            if(!$row) {
                return null;
            }

            if(!password_verify($password, $row['password'])) {
                return null;
            }

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_role'] = $row['role'];


            return new User($row['id'], $row['name'], $row['password'], $row['role']);
            
        }

        public function logOut()
        {
            if(session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION = [];
                session_destroy();
                return true;
            }
                return null;
        }

        public function getCurrentUser()
        {
            if(session_status() !== PHP_SESSION_NONE && isset($_SESSION['user_id'])) {
                
                return new User($_SESSION['user_id'], $_SESSION['user_name'], '', $_SESSION['user_role']);
            }
                return null;
        }
    }
?>