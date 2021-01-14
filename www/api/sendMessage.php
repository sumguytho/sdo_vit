<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $message = $_POST['message'];
    $chatId = $_POST['chatId'];
    $userId = $_SESSION['id'];

    $date = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO message (chatId, userId, content, date) VALUES ('$chatId','$userId','$message','$date')");
    echo mysqli_error($conn);


    mysqli_close($conn);

}