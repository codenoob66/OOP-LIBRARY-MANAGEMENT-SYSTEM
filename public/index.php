<?php
    spl_autoload_register(function ($className) {
    $directories = ['classes', 'database'];

    for($i = 0; $i <  count($directories); $i++) {
        $filepath = __DIR__ . '/../' . $directories[$i] . '/' . $className . '.php';

        if(file_exists($filepath)) {
            include $filepath;
            return;
        }

    }
    });


?>