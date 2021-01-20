<?
	$msg = "<div>Попытка добавить новый чат для пользователя root:</div>";
    $msg .="<div>Ожидаемый результат:</div>";
    $expected = array();
    $expected[0] = 26;

    foreach($expected as $el){
        $msg .= "<div>".$el."</div>";
    }

    $userIds = array(3);
    $name = "cht1";
    $date = date('2020-06-01 00:00:00');

    mysqli_query($conn, "INSERT INTO chat (creationDate, name) VALUES ('$date','$name')");
    echo mysqli_error($conn);
    $last_id = mysqli_insert_id($conn);
    $status = array();
    $status[] = $last_id;
    $id = 3;
    mysqli_query($conn, "INSERT INTO message (chatId, userId, content, date) VALUES ('$last_id','$id','Чат создан!','$date')");
    foreach ($userIds as $user) {
        mysqli_query($conn, "INSERT INTO chat_membership ( userId, chatId) VALUES ('$user', '$last_id')");
    }

    $err = 0;

    if(is_array($status)){
        $msg .= "<div>Реальный результат:</div>";
        for($i = 0; $i < count($status); $i++){
            $msg .= "<div>".$status[$i]."</div>";
            if(!isset($expected[$i]) || $expected[$i] != $status[$i]){
                $err = 1;
            }
        }
    }
    else{
        $msg .= "<div>База данных недоступна</div>";
        $err = 1;
    }

    if($err) { 
        $msg .= "<div>Тест провален</div>"; 
        array_push($res, 'failure'); 
    }
    else { 
        $msg .= "<div>Тест пройден</div>"; 
        array_push($res, 'success'); 
    }
    array_push($content, $msg);

?>