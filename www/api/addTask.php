<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $userIds = $_POST["deskId"];
    $name = $_POST["name"];
    $date = $_POST["date"];

    mysqli_query($conn, "INSERT INTO task (deskId, name, description, date) VALUES ('$date','$name')");
    echo mysqli_error($conn);




    mysqli_close($conn);

}