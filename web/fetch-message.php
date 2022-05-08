<?php

if (isset($_GET['id'])) {
    $db = new PDO('sqlite:..\database\dienynas.db');
    $sql = "SELECT [message] FROM grades WHERE ID = '" . $_GET["id"] . "' AND status <> 'D';";
    $result = $db->query($sql);
    $message = $result->fetchColumn(0);

    $data = '{"message":"'.$message.'"}';

    echo json_encode($data);
} else {
    echo json_encode(array('success' => 0));
}
