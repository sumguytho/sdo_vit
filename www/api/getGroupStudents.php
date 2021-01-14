<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

global $db_param;
$conn = connect_db($db_param);

if ($conn) {

    $name = $_POST['name'];
    $result = mysqli_query($conn, "SELECT
  *
FROM user
  INNER JOIN `group`
    ON user.groupId = `group`.groupId
    where `group`.name='$name'");

    echo mysqli_error($conn);

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }

    echo json_encode($json);
    mysqli_close($conn);

}