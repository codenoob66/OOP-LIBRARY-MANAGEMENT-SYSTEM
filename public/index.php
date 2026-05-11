<?php
    spl_autoload_register(function ($className) {
    include __DIR__ . '/../classes/' . $className . '.php';
    });

    

    $rafael = new User(1, "Rafale");
    $b1 = new Book(1, "Sugar", "luke sky walker", 5);
    $b2 = new Book(2, "The one that got away", "Zach efron", 2);
    $rafael->borrowBook($b1);
    $rafael->borrowBook($b2);

    $books = $rafael->getBorrowedBooks();


    foreach($books as $book) {
        echo $book->getTitle() . '<br>';
    }


    

?>