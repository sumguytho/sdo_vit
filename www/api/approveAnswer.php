<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $id = $_POST['id'];



    mysqli_query($conn, "UPDATE answer SET approve = 1 WHERE id = '$id'");


    echo mysqli_error($conn);


    mysqli_close($conn);

}