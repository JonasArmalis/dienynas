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
        <h1>Pasirinktos klasės mokinių vidurkiai </h1>

        <form class="form-group" id="subjectForm" action="class-average.php" method="POST">
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

        $averages = array();
        $getClassesSql = "SELECT * FROM classes WHERE status <> 'D';";
        $classes = $db->query($getClassesSql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($classes as $key => $class) {
            if ($subjectID == 0) {
                $getAvgSql = "SELECT AVG(g.grade) as 'average', c.class FROM grades g
                JOIN students s on s.ID = g.studentID
                JOIN classes c on c.ID = s.classID
                JOIN subjects d on d.ID = g.subjectID
                WHERE g.status <> 'D' AND c.ID = '" . $class["ID"] . "';";
            } else {
                $getAvgSql = "SELECT AVG(g.grade) as 'average', c.class FROM grades g
                JOIN students s on s.ID = g.studentID
                JOIN classes c on c.ID = s.classID
                JOIN subjects d on d.ID = g.subjectID
                WHERE g.status <> 'D' AND g.subjectID = '" . $subjectID . "' AND c.ID = '" . $class["ID"] . "';";
            }
            $classesAvg = $db->query($getAvgSql)->fetchAll(PDO::FETCH_ASSOC);
            $averages[$key]["avg"] = $classesAvg[0]["average"];
            $averages[$key]["class"] = $classesAvg[0]["class"];
        }

        ?>



        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Klasė</th>
                    <th scope="col">Vidurkis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                   include 'sort-callbacks.php';
                   usort($averages, "compare3");
                foreach ($averages as $average) {
                    echo "<tr>";

                    if (round($average["avg"], 2) > 1) {
                        echo "<td>" . $average['class'] . "</td>";
                        echo "<td>" . round($average["avg"], 2) . "</td>";
                    }
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </div>

</body>