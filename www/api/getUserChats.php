<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");






    global $db_param;
    $conn = connect_db($db_param);

if ($conn) {


    $login = $_SESSION["logUser"];

    $result = mysqli_query($conn, "SELECT idUser FROM user WHERE login='$login'");

    $id = $result->fetch_assoc();
    $id = $id['idUser'];
    $_SESSION['id'] = $id;

    $sql = "SELECT
  chat_membership.userId,
  chat.name,
  chat.chatId
FROM chat_membership
  INNER JOIN chat
    ON chat_membership.chatId = chat.chatId
    WHERE chat_membership.userId = '$id'";

    $result = mysqli_query($conn, $sql);
    echo mysqli_error($conn);

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }

    echo json_encode($json);

    mysqli_close($conn);



}