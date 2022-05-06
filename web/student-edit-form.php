<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="center">
        <?php
        $studentID = $_GET['studentID'];
        $db = new PDO('sqlite:..\database\dienynas.db');

        $getStudent = "SELECT * FROM students WHERE ID = '" . $studentID . "';";
        $student = $db->query($getStudent)->fetchAll(PDO::FETCH_ASSOC)[0];

        ?>
        <h1>Mokinio redagavimas <br>
            <?php
            echo  $student["name"] . " " . $student["surname"];
           ?>
        </h1>

        <form class="form-group" action="student-edit.php?id='<?php $studentID ?>' method="POST">
            Vardas:
            <input type="text" value = "<?php echo $student["name"]?>" class="form-control" name="newName"> <br>
            Pavardė:
            <input type="text" value = "<?php echo $student["surname"]?>" class="form-control" name="newSurname"> <br>
            Klasė:
            <select class="form-select" aria-label="Default select example" name="newClassID" >
                <?php
                $sql = "SELECT * FROM classes WHERE [status] <> 'D';";
                $result = $db->query($sql);

                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    if ($row["ID"] == $student["classID"]) {
                        echo "<option selected value=" . $row["ID"] . ">" . $row["class"] . "</option>";
                    } else {
                        echo "<option value=" . $row["ID"] . ">" . $row["class"] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <input name="action" value="Update" type="submit" class="btn btn-primary" value="Išsaugoti">
            <input name="action" value="Delete" type="submit" class="btn btn-danger" value="Ištrinti">
            <input name="id" value="<?php echo $studentID?>"style="display:none">
             
        </form>
    
    </div>
</body>

</html>