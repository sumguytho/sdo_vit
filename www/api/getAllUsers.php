<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $date = date('Y-m-d H:i:s');
    $result = mysqli_query($conn, "SELECT * FROM user");

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }

    echo json_encode($json);
    mysqli_close($conn);

}