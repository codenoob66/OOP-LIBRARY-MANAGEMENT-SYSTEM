<?php
    class User
    {
        private int $id;
        private string $name;
        private array $borrowedBooks = [];
        private int $allowedBooksToBorrow = 5;


        public function __construct(int $id, string $name)   
        {
            $this->id = $id;
            $this->name = $name;

        }

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }


        public function returnBook(Book $book)
        {
           
            if(in_array($book, $this->borrowedBooks)) {
                if (($key = array_search($book, $this->borrowedBooks)) !== false) {
                unset($this->borrowedBooks[$key]);
                $this->borrowedBooks = array_values($this->borrowedBooks);
                 $book->returnBook();
                 return true;
                }
            }
                return false;
        }

        public function borrowBook(Book $book)
        {

            if(count($this->borrowedBooks) >= $this->allowedBooksToBorrow) {
                return false;
            }
            if(in_array($book, $this->borrowedBooks)) {
                return false;
            } else {
                if($book->borrowBook() == true){
                array_push($this->borrowedBooks, $book);
                return true;
                }
                return false;
            }
        }

        public function getBorrowedBooks(): array
        {
            
            return $this->borrowedBooks;
        }
    }
?>