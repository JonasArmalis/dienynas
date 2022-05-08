<html>

<head>
</head>

<body>
    <?php
    $gradeID = $_POST['gradeID'];
    $newGrade = $_POST['newGrade'];
    $newMessage = $_POST['newMessage'];

    $pdo = new PDO('sqlite:..\database\dienynas.db');


    echo $newMessage;
    if ($_POST['action'] == 'Update') {
        $updateGradeSql = "UPDATE grades SET grade = '". $newGrade."', message = '". $newMessage."' WHERE ID  = '".$gradeID."';";
        $pdo->exec($updateGradeSql);
    }
    else if ($_POST['action'] == 'Delete') {
        $updateGradeSql = "UPDATE grades SET `status` = 'D' WHERE ID = '" . $gradeID . "';";
        $pdo->exec($updateGradeSql);
    }

    header('Location: student_average.php');
    ?>
</body>

</html>