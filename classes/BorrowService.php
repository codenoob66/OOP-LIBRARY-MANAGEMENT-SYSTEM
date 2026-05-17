<?php
    
    class BorrowService
    {
        private PDO $db;
        private int $allowedBooksToBorrow = 5;

        public function __construct(PDO $db)
        {
            $this->db = $db;
        }

        public function borrowBook(User $user, Book $book)
        {

            $stmt = $this->db->prepare(
                "SELECT COUNT(*)
                FROM loan_tbl
                WHERE user_id = :user_id
                AND returned_at is NULL"
            );

            $stmt->execute([
                ':user_id' => $user->getId()
            ]);

            $bookCount = $stmt->fetchColumn();

            if($bookCount >= $this->allowedBooksToBorrow) {
                return false;
            }
            
            $stmt = $this->db->prepare(
                "SELECT COUNT(*)
                FROM loan_tbl
                WHERE user_id = :user_id
                AND book_id = :book_id
                AND returned_at IS NULL"
            );


            $stmt->execute([
                ':user_id' => $user->getId(),
                ':book_id' => $book->getId()
            ]);

            $alreadyBorrowed = $stmt->fetchColumn();

            if($alreadyBorrowed > 0) {
                return false;
            }

            $stmt = $this->db->prepare(
                "SELECT available_copies
                FROM book_tbl
                WHERE id = :book_id"
            );

            $stmt->execute([
                ':book_id' => $book->getId()
            ]);

            $availableCopies = $stmt->fetchColumn();

            if($availableCopies <= 0) {
                return false;
            }
                try {
                    $this->db->beginTransaction();
                    
                    $stmt = $this->db->prepare(
                        "INSERT INTO loan_tbl (user_id, book_id, borrow_date, returned_at)
                        VALUES (:user_id, :book_id, CURDATE(), NULL)"
                    );

                    $stmt->execute([
                        ':user_id' => $user->getId(),
                        ':book_id' => $book->getId()
                    ]);

                    $stmt = $this->db->prepare(
                        "UPDATE book_tbl SET available_copies = available_copies - 1
                        WHERE  id = :book_id
                        AND available_copies > 0"
                    );

                    $stmt->execute([
                        ':book_id' => $book->getId()
                    ]);

                    if($stmt->rowCount() === 0) {
                        $this->db->rollBack();
                        return false;
                    }

                    $this->db->commit();

                } catch(PDOException $e) {
                    $this->db->rollBack();
                    return false;
                }
                    return true;
        }

        public function returnBook(User $user, Book $book)
        {
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare(
                    "UPDATE loan_tbl SET returned_at = NOW()
                    WHERE user_id = :user_id
                    AND book_id = :book_id
                    AND returned_at IS NULL"
                );

                $stmt->execute([
                    ':user_id' => $user->getId(),
                    ':book_id' => $book->getId()
                ]);

                if($stmt->rowCount() === 0) {
                    $this->db->rollBack();
                    return false;
                }
                
                $stmt = $this->db->prepare(
                    "UPDATE book_tbl SET available_copies = available_copies + 1
                    WHERE id = :book_id"
                );

                $stmt->execute([
                    ':book_id' => $book->getId()
                ]);

                if($stmt->rowCount() === 0) {
                    $this->db->rollBack();
                    return false;
                }

                $this->db->commit();
                return true;

            } catch (PDOException $error) {
                $this->db->rollBack();
                return false;
            }
        }


        public function getAllBooks(): array
        {
            $stmt = $this->db->prepare(
                "SELECT id, title, author, available_copies 
                FROM book_tbl"
            );

            $stmt->execute();

            $bookArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $books = [];

            foreach($bookArray as $row) {
                $books[] = new Book($row['id'], $row['title'], $row['author'], $row['available_copies']);
            }

            return $books;
    
        }

        public function getBorrowedBooksByUser(User $user): array
        {
            $stmt = $this->db->prepare(
                "SELECT book_tbl.id, book_tbl.author, book_tbl.title, book_tbl.available_copies
                FROM loan_tbl
                JOIN book_tbl ON loan_tbl.book_id = book_tbl.id
                WHERE loan_tbl.user_id = :user_id
                AND loan_tbl.returned_at is NULL"
            );


            $stmt->execute([
                ':user_id' => $user->getId()
            ]);


            
            $bookArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $books = [];

            foreach($bookArray as $row) {
                $books[] = new Book($row['id'], $row['title'], $row['author'], $row['available_copies']);
            }

            return $books;
            
        }
    }
?>
