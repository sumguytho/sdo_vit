<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $id = $_POST['id'];


    $result = mysqli_query($conn, "SELECT permissions FROM user WHERE idUser = '$id'");
    $a = $result->fetch_row()[0];
    if($a == 2)
        mysqli_query($conn, "UPDATE user SET permissions = '1' WHERE idUser = '$id'");

    if($a == 1)
        mysqli_query($conn, "UPDATE user SET permissions = '2' WHERE idUser = '$id'");
    echo mysqli_error($conn);


    mysqli_close($conn);

}