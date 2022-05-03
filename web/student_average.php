<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php include 'header.php';?>
    <div>
        <h1>Pasirinkto mokinio vidurkiai </h1>

        <form class="form-group" name="studentForm" action="student_average.php" method="POST">
            <h6>Pasirinkite mokinį:</h6>
            <select class="form-select" aria-label="Default select example" name="studentID" onchange="this.form.submit()">
                <?php

                if (isset($_POST)) {
                    $studentID = $_POST['studentID'];
                }
                $db = new PDO('sqlite:..\database\dienynas.db');
                $sql = "SELECT * FROM students WHERE ([status] IS NULL OR [status] = 'U');";
                $result = $db->query($sql);

                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    if ($row["ID"] == $studentID) {
                        echo "<option selected value=" . $row["ID"] . ">" . $row["name"] . " " . $row["surname"] . "</option>";
                    } else {
                        echo "<option value=" . $row["ID"] . ">" . $row["name"] . " " . $row["surname"] . "</option>";
                    }
                }
                ?>
            </select>
        </form>
        <?php

        /*$getStudentsSql = "SELECT  s.ID ,c.class, s.name, s.surname FROM students s
        JOIN classes c on s.classID = c.ID
        WHERE (s.[status] IS NULL OR s.[status] = 'U');";
    
        $subjects = $db->query($getStudentsSql)->fetchAll(PDO::FETCH_ASSOC);
        */
        $getSubjectsSql = "SELECT * FROM subjects";
        $subjects = $db->query($getSubjectsSql)->fetchAll(PDO::FETCH_ASSOC);
        if ($studentID == NULL) {
            $studentID = 1;
        }


        foreach ($subjects as $key => $subject) {
            $getGradesSql = "SELECT grade FROM grades WHERE studentID = '" . $studentID . "' AND subjectID = '" . $subject["ID"] . "' AND ([status] IS NULL OR [status] = 'U');";
            $getAvgSql = "SELECT AVG(grade) average FROM grades WHERE studentID = '" . $studentID . "' AND subjectID= '" . $subject["ID"] . "'  AND ([status] IS NULL OR [status] = 'U');";
            $avg = $db->query($getAvgSql)->fetchAll(PDO::FETCH_ASSOC)[0]["average"];
            $grades = $db->query($getGradesSql)->fetchAll(PDO::FETCH_ASSOC);
            $subjects[$key]["grades"] = "";
            foreach ($grades as  $grade) {
                $subjects[$key]["grades"] = $subjects[$key]["grades"] . " " . $grade["grade"];
            }
            $subjects[$key]["average"] = $avg;
        }
        $getAllAvgSql = "SELECT AVG(grade) average FROM grades WHERE studentID = '" . $studentID . "' AND ([status] IS NULL OR [status] = 'U');";
        $getAllGradesSql = "SELECT grade FROM grades WHERE studentID = '" . $studentID . "' AND ([status] IS NULL OR [status] = 'U');";

        $allAvg =  $db->query($getAllAvgSql)->fetchAll(PDO::FETCH_ASSOC)[0]["average"];
        $allGrades =  $db->query($getAllGradesSql)->fetchAll(PDO::FETCH_ASSOC);

        ?>



        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Dalykas</th>
                    <th scope="col">Pažymiai</th>
                    <th scope="col">Klasė</th>
                    <th scope="col"></th>
                    <th scope="col">Vidurkis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                rsort($subjects);
                foreach ($subjects as $subject) {
                    echo "<tr>";
                    echo "<td>" . $subject["subject"] . "</td>";
                    echo "<td>" . $subject["grades"] . "</td>";
                    /*echo "<td>" . $subject['class']. "</td>";*/
                    if (round($subject["average"], 2) < 1) {
                        echo "<td> - </td>";
                        echo "<td> - </td>";
                    } else {
                        echo '<td> <a  href="grade-edit-form.php?subjectID=' . $subject["ID"] . '&studentID=' . $studentID . '" class="btn btn-outline-dark">Redaguoti </a> </td>';
                        echo "<td>" . round($subject["average"], 2) . "</td>";
                    }



                    echo "</tr>";
                }
                ?>

                <tr>
                    <td> Visi dalykai</td>
                    <td>
                        <?php
                        foreach ($allGrades as $grade) {
                            echo $grade["grade"] . " ";
                        }
                        ?>
                    </td>
                    <td> </td>
                    <td><?php echo round($allAvg, 2) ?></td>
                </tr>

            </tbody>
        </table>
    </div>

</body>