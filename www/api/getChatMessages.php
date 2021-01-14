<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {


    $chatId = $_POST['chatId'];




    $result = mysqli_query($conn, "SELECT
  chat.name as chatName,
  user.name,
  user.surname,
  message.content,
  message.date
FROM message
  INNER JOIN chat
    ON message.chatId = chat.chatId
  INNER JOIN user
    ON message.userId = user.idUser
    WHERE chat.chatId='$chatId'");
    echo mysqli_error($conn);

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }


    echo json_encode($json);

    mysqli_close($conn);

}