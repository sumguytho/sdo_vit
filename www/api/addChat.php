<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $userIds = $_POST["userIds"];
    $name = $_POST["name"];
    $date = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO chat (creationDate, name) VALUES ('$date','$name')");
    echo mysqli_error($conn);
    $last_id = mysqli_insert_id($conn);
    $json[] = $last_id;
    $id = $_SESSION['id'];
    mysqli_query($conn, "INSERT INTO message (chatId, userId, content, date) VALUES ('$last_id','$id','Чат создан!','$date')");
    foreach ($userIds as $user) {
        mysqli_query($conn, "INSERT INTO chat_membership ( userId, chatId) VALUES ('$user', '$last_id')");
    }






    echo json_encode($json);
    mysqli_close($conn);

}