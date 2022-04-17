<?php

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    $statement = $pdo->query("SELECT * FROM students");

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($rows);
    echo "</pre>";
    
    ?>