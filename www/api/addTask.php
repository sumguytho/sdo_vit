<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $deskId = $_POST["deskId"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $desc = $_POST["description"];

    mysqli_query($conn, "INSERT INTO task (deskId, name, description, date) VALUES ('$deskId','$name','$desc','$date')");
    echo mysqli_error($conn);




    mysqli_close($conn);

}