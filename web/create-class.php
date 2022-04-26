<html>

<head>
</head>

<body>
    <?php
    $class = $_POST['class'];
    $pdo = new PDO('sqlite:..\database\dienynas.db');

    $insert_class = "INSERT INTO classes (ID, class) VALUES (NULL, '" . $class . "');";
    $success = $pdo->exec($insert_class);

    if ($success) {
        echo "success <br>";
    }
    header('Location: main.php');
    ?>
</body>

</html>