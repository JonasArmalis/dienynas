<html>

<head>
</head>

<body>
    <?php
    $id = $_GET["id"];
    $newName = $_GET['newName'];
    $newSurname = $_GET['newSurname'];
    $newClassID = $_GET['newClassID'];
  

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    if ($_GET['action'] == 'Update') {
        $updateStudentSql = "UPDATE students SET `name` = '". $newName."', `surname` = '". $newSurname."', `classID` = '". $newClassID."' WHERE ID  = '".$id."' AND [status] <> 'D';";
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