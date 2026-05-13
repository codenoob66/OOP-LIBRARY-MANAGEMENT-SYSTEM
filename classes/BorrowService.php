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
            $bookCount = count($user->getBorrowedBooks());
            $books_Array = $user->getBorrowedBooks();

            if($bookCount >= $this->allowedBooksToBorrow) {
                return false;
            }
            if(in_array($book, $books_Array)) {
                return false;
            } else {
                if($book->borrowBook() == true) {
                   $user->addBorrowedBook($book);
                   return true;
                }
            }
        }

        public function returnBook(User $user, Book $book)
        {
            if($user->returnBook($book)) {
                $book->returnBook();
                return true;
            }
                return false;
        }
    }
?>