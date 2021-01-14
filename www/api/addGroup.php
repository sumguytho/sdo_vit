<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {


    $name = $_POST["name"];


    mysqli_query($conn, "INSERT INTO chat (name) VALUES ('$name')");
    echo mysqli_error($conn);







    mysqli_close($conn);

}