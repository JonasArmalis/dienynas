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
    <?php include 'header.php'; ?>
    <div>
        <h1>Bendri visų mokinių vidurkiai</h1>

        <form class="form-group" id="subjectForm" action="all_average.php" method="POST">
            <h6>Dalykas:</h6>
            <select class="form-select" aria-label="Default select example" name="subjectID" onchange="this.form.submit()">
                <option selected value="0">visi dalykai</option>
                <?php

                if (isset($_POST)) {
                    $subjectID = $_POST['subjectID'];
                }

                $db = new PDO('sqlite:..\database\dienynas.db');
                $sql = "SELECT ID, subject FROM subjects;";
                $result = $db->query($sql);

                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    if ($row["ID"] == $subjectID) {
                        echo "<option selected value=" . $row["ID"] . ">" . $row["subject"] . "</option>";
                    } else {
                        echo "<option value=" . $row["ID"] . ">" . $row["subject"] . "</option>";
                    }
                }
                ?>
            </select>
        </form>
        <?php
        //include 'include/student.inc.php';


        $averages = array();
        $getStudentsSql = "SELECT * FROM students WHERE ([status] IS NULL OR [status] = 'U');";
        $students = $db->query($getStudentsSql)->fetchAll(PDO::FETCH_ASSOC);


        if ($subjectID == 0) {
            $i = 0;
            foreach ($students as $student) {
                $getAvgSql = "SELECT AVG(grade) average, s.name, s.surname FROM grades g
            JOIN students s on g.studentID = s.ID
            WHERE g.studentID = '" . $student['ID'] . "' AND (g.[status] IS NULL OR g.[status] = 'U');";
                $studentsAvg = $db->query($getAvgSql)->fetchAll(PDO::FETCH_ASSOC);
                $averages[$i]["avg"] = $studentsAvg[0]["average"];
                $averages[$i]["name"] = $studentsAvg[0]["name"];
                $averages[$i]["surname"] = $studentsAvg[0]["surname"];
                $i = $i + 1;
            }
        } else {
            $i = 0;
            foreach ($students as $student) {
                $getAvgSql = "SELECT AVG(grade) average, s.name, s.surname FROM grades g
            JOIN students s on g.studentID = s.ID
            WHERE g.studentID = '" . $student["ID"] . "' AND subjectID = '" . $subjectID . "' AND (g.[status] IS NULL OR g.[status] = 'U');";
                $studentsAvg = $db->query($getAvgSql)->fetchAll(PDO::FETCH_ASSOC);
                $averages[$i]["avg"] = $studentsAvg[0]["average"];
                $averages[$i]["name"] = $studentsAvg[0]["name"];
                $averages[$i]["surname"] = $studentsAvg[0]["surname"];
                $i = $i + 1;
            }
        }
        ?>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Vardas</th>
                    <th scope="col">Pavardė</th>
                    <th scope="col">Vidurkis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                rsort($averages);
                foreach ($averages as $average) {
                    if ($average['name'] != NULL && $average['surname'] != NULL && $average['avg'] != NULL) {
                        echo "<tr>";
                        echo "<td>" . $average['name'] . "</td>";
                        echo "<td>" . $average['surname'] . "</td>";
                        echo "<td>" . round($average['avg'], 2) . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>


</body>