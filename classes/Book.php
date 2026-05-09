<?php
    class Book {
        private $id;
        private $title;
        private $author;
        private $availableCopies;

        public function __construct($id, $title, $author, $availableCopies)   
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