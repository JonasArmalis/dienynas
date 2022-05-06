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
        <h1>Pridėti mokinį</h1> 

        <form class="form-group" action="create-student.php" method="POST">
            Vardas<input type="text" class="form-control" name="Name"> <br>
            Pavardė<input type="text" class="form-control" name="Surname"> <br>       
            Pasirinkite klase:
            <select class="form-select" aria-label="Default select example" name="ClassID">
                <?php

                $pdo = new PDO('sqlite:..\database\dienynas.db');
                $sql = "SELECT * FROM classes ;";
                $result = $pdo->query($sql);

                $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    echo "<option value=" . $row["ID"] . ">" . $row["class"] . "</option>";
                }
                ?>
            </select> <br>
            <input type="submit" class="btn btn-primary" value="Įrašyti">
        </form>
    </div>
</body>

</html>