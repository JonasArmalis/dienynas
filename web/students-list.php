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
    <?php include 'header.php';

    $pdo = new PDO('sqlite:..\database\dienynas.db');
    $getStudentsSql = "SELECT  s.ID ,c.class, s.name, s.surname FROM students s
    JOIN classes c on s.classID = c.ID
    WHERE (s.[status] IS NULL OR s.[status] = 'U');";

    $results = $pdo->query($getStudentsSql)->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <h1 class ="head">Mokinių sąrašas</h1>
    <div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Vardas</th>
                    <th scope="col">Pavardė</th>
                    <th scope="col">Klasė</th>
                    <th scope="col"> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result) {
                    echo "<tr>";    
                    echo "<td>";
                    echo $result['name'];
                    echo "</td>";
                    echo "<td>";
                    echo $result['surname'];
                    echo "</td>";
                    echo "<td>";
                    echo $result['class'];
                    echo "</td>";
                    echo "<td>";
                    echo '<a  href="student-edit-form.php?studentID='.$result["ID"].'" class="btn btn-outline-dark">Redaguoti </a>';
                    echo "</td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>