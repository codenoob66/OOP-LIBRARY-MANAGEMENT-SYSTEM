<?php


    spl_autoload_register(function ($className) {
    $directories = ['classes', 'database'];

    // foreach($directories as $dir) {
    //     $filepath = __DIR__ . '/../' . $dir . '/' . $className . '.php';
        
    //     if(file_exists($filepath)) {
    //         include $filepath;
    //         return;
    //     }
    // }

    for($i = 0; $i <= count($directories); $i++) {
        $filepath = __DIR__ . '/../' . $directories[$i] . '/' . $className . '.php';

        if(file_exists($filepath)) {
            include $filepath;
            return;
        }

    }
    });

    $db1 = Database::getConnection();
    $db2 = Database::getConnection();

    if ($db1 === $db2) {
    echo "Singleton works!";
} else {
    echo "Singleton failed!";
}
?>