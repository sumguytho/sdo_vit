<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {


    $id = $_POST["id"];
    $result = mysqli_query($conn, "SELECT
  *
FROM answer
  INNER JOIN `task`
    ON answer.taskId = task.taskId
  INNER JOIN user
    ON answer.userId = user.idUser
    WHERE task.taskId='$id'");

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }

    echo json_encode($json);
    mysqli_close($conn);

}