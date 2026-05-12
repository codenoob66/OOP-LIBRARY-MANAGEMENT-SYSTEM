<?php
    class User
    {
        private int $id;
        private string $name;
        private array $borrowedBooks = [];


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


        // public function returnBook(Book $book)
        // {
           
        //     if(in_array($book, $this->borrowedBooks)) {
        //         if (($key = array_search($book, $this->borrowedBooks)) !== false) {
        //         unset($this->borrowedBooks[$key]);
        //         $this->borrowedBooks = array_values($this->borrowedBooks);
        //          $book->returnBook();
        //          return true;
        //         }
        //     }
        //         return false;
        // }

        public function getBorrowedBooks(): array
        {
            return $this->borrowedBooks;
        }

        public function addBorrowedBook(Book $book)
        {
            return $this->borrowedBooks[] = $book;
        }

        public function returnBook(Book $book)
        {
            if(in_array($book, $this->borrowedBooks)){

                if (($key = array_search($book, $this->borrowedBooks)) !== false) {
                unset($this->borrowedBooks[$key]);
                $this->borrowedBooks = array_values($this->borrowedBooks);
                return true;

                }
            }
        }
    }
?>