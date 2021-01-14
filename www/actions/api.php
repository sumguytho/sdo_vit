<?
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");


function getChat($index) {
    global $db_param;
    $conn = connect_db($db_param);

    if ($conn) {
        $chat = mysqli_query($conn, 'SELECT * FROM chat WHERE chatId='+$index);
        $_SESSION['chatInfo'] = $chat->fetch_assoc();

        $messages = mysqli_query($conn, 'SELECT * FROM message WHERE chatId='+$chat->fetch_assoc()['chatId']);
        $_SESSION['chatMessages'] = $messages;




        mysqli_close($conn);

    }

}

function getAllChats() {


    if(isset($userInfo)) {
        $userId = $userInfo['userId'];
    }
    global $db_param;
    $conn = connect_db($db_param);

    if ($conn) {





        $sql = "SELECT
  chat_membership.userId,
  chat.name
FROM chat_membership
  INNER JOIN chat
    ON chat_membership.chatId = chat.chatId
    WHERE chat_membership.userId = '$userId'";

        $result = mysqli_query($conn, $sql);

        while($row = $result->fetch_assoc()){
            $json[] = $row;
        }

        echo json_encode($json);

        mysqli_close($conn);

    }

}


function addChat($userIds, $name) {
    global $db_param;
    $conn = connect_db($db_param);

    if ($conn) {

        $date = date('Y-m-d H:i:s');
        mysqli_query($conn, "INSERT INTO chat (null, $date, $name)");

        $chatId = $last_id = mysqli_insert_id($conn);
        foreach ($userIds as $user) {
            mysqli_query($conn, "INSERT INTO chat_membership (null, $user, $chatId)");
        }

        mysqli_close($conn);

    }

}



function getAllUsers() {
    global $db_param;
    $conn = connect_db($db_param);

    if ($conn) {

        $date = date('Y-m-d H:i:s');
        mysqli_query($conn, "SELECT * FROM user");



        mysqli_close($conn);

    }

}




?>