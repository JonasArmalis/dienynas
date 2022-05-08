<html>

<head>
</head>

<body>
    <?php
    $student_ID = $_POST['studentID'];
    $subject_ID = $_POST['subjectID'];
    $grade = $_POST['grade'];
    $message = $_POST['message'];

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    $insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade, `message`) VALUES (NULL, '" . $student_ID . "', '" . $subject_ID . "', '" . $grade . "', '".$message."');";
    $success = $pdo->exec($insert_grade);
    echo $insert_grade;
    if ($success) {
        echo "success <br>";
    }
    header('Location: all_average.php');
    ?>
</body>

</html>