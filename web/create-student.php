<html>

<head>
</head>

<body>
    <?php
    $Name = $_POST['Name'];
    $Surname = $_POST['Surname'];

    $pdo = new PDO('sqlite:..\database\dienynas.db');

    //Checks is a students with a given name and sruname exists
    $studentExists = false;
    $select_students = "SELECT * FROM students;";
    $result = $pdo->query($select_students);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        if ($row['name'] == $Name && $row['surname'] == $Surname) {
            if($row['status'] == "D")
            {
                $updateStatusSql = "UPDATE students SET `status` = 'U' WHERE ID  = '".$row["ID"]."';";
                $pdo->exec($updateStatusSql);
            }
            $student_ID = $row["ID"];
            $studentExists = true;
        }
    }

    if (!$studentExists) {
        $create_student = "INSERT INTO students (ID, name, surname) VALUES ( NULL, '" . $Name . "', '" . $Surname . "');";
        $pdo->exec($create_student);
    }

    header('Location: all_average.php');
    ?>
</body>

</html>