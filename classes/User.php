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


        public function returnBook($book)
        {
            $id = $book->getId();
            if(in_array($id, $this->borrowedBooks)) {
                if (($key = array_search($id, $this->borrowedBooks)) !== false) {
                unset($this->borrowedBooks[$key]);
                $this->borrowedBooks = array_values($this->borrowedBooks);
                 $book->returnBook();
                 return true;
                }
            }
                return false;
        }

        public function borrowBook($book)
        {
            $id = $book->getId();
            if(count($this->borrowedBooks) >= $this->allowedBooksToBorrow) {
                return false;
            }
            if(in_array($id, $this->borrowedBooks)) {
                return false;
            } else {
                if($book->borrowBook() == true){
                $id = $book->getId();
                array_push($this->borrowedBooks, $id);
                return true;
                }
                return false;
            }
        }
    }
?>