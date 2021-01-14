<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $answer = $_POST['answer'];
    $taskId = $_POST['taskId'];
    $userId = $_SESSION['id'];


    mysqli_query($conn, "INSERT INTO answer (answer, userId, taskId, approve) VALUES ('$answer','$userId','$taskId',0)");
    echo mysqli_error($conn);


    mysqli_close($conn);

}