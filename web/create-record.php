<html>

<head>
</head>

<body>
    <?php
    $student_ID = $_POST['studentID'];
    $subject_ID = $_POST['subjectID'];
    $grade = $_POST['grade'];

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    $insert_grade = "INSERT INTO grades (ID, studentID, subjectID, grade) VALUES (NULL, '" . $student_ID . "', '" . $subject_ID . "', '" . $grade . "');";
    $success = $pdo->exec($insert_grade);
    echo $insert_grade;
    if ($success) {
        echo "success <br>";
    }
    header('Location: all_average.php');
    ?>
</body>

</html>