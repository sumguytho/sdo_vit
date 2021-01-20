<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $name= $_POST["name"];


    mysqli_query($conn, "INSERT INTO desk (name, userId) VALUES ('$name',4)");
    $last_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO desk_membership (deskId, groupId) VALUES ('$last_id',1)");
    mysqli_query($conn, "INSERT INTO desk_membership (deskId, groupId) VALUES ('$last_id',2)");
    echo mysqli_error($conn);




    mysqli_close($conn);

}