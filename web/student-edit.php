<html>

<head>
</head>

<body>
    <?php
    $id = $_GET["id"];
    $newName = $_GET['newName'];
    $newSurname = $_GET['newSurname'];

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    if ($_GET['action'] == 'Update') {
        $updateStudentSql = "UPDATE students SET `name` = '". $newName."', `surname` = '". $newSurname."' WHERE ID  = '".$id."' AND ([status] IS NULL OR [status] = 'U');";
        $pdo->exec($updateStudentSql);
    }
    else if ($_GET['action'] == 'Delete') {
        $updateStudentSql = "UPDATE students SET `status` = 'D' WHERE ID = '" . $id . "';";
        $pdo->exec($updateStudentSql);
    }

    header('Location: students-list.php');
    ?>
</body>

</html>