<?php
    class Book {
        private int $id;
        private string $title;
        private string $author;
        private int $availableCopies;

        public function __construct(int $id, string $title, string $author, int $availableCopies)   
        {
            $this->id = $id;
            $this->title = $title;
            $this->author = $author;
            $this->availableCopies = $availableCopies;
        }


        public function getTitle() 
        {
            return $this->title;
        }

        public function getAuthor()
        {
            return $this->author;
        }


        public function borrowBook()
        {
            if($this->availableCopies > 0)
            {
                $this->availableCopies--;
                return true;
            }

            return false;
        }

        public function returnBook()
        {
            $this->availableCopies++;
        }

        public function getId()
        {
            return $this->id;
        }
    }
?>