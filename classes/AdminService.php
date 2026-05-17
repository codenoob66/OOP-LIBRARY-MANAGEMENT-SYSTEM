<?php
    class AdminService
    {
        private PDO $db;

        public function __construct(PDO $db)
        {
            $this->db = $db;
        }


        public function addBook(User $admin, string $author, string $title, int $available_copies)
        {
            
            if($admin->getRole() !== 'admin'){
                return false;
            }

            try {

            $this->db->beginTransaction();

                $stmt = $this->db->prepare(
                    "INSERT into book_tbl (author, title, available_copies)
                    VALUES (:author, :title, :available_copies)"
                );

                $stmt->execute([
                    ':author' => $author,
                    ':title' => $title,
                    ':available_copies' => $available_copies

                ]);

                $this->db->commit();

                return true;


            }catch(PDOException $e) {
                $this->db->rollBack();
                return false;
            }
        }
    }

?>