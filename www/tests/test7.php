<?
	$msg = "<div>Попытка получить сообщения для чата первый чат:</div>";
    $msg .="<div>Ожидаемый результат:</div>";
    $expected = array();
    $expected[0] = "sdf";
    foreach($expected as $el){
        $msg .= "<div>".$el."</div>";
    }

    $result = mysqli_query($conn, "SELECT
  chat.name as chatName,
  user.name,
  user.surname,
  message.content,
  message.date
FROM message
  INNER JOIN chat
    ON message.chatId = chat.chatId
  INNER JOIN user
    ON message.userId = user.idUser
    WHERE chat.chatId=10");

    while($row = $result->fetch_assoc()){
        $json[] = $row;
    }

    $err = 0;

    if(is_array($json)){
        $msg .= "<div>Реальный результат:</div>";
        for($i = 0; $i < count($json); $i++){
            $msg .= "<div>".$json[$i]['content']."</div>";
            if(!isset($expected[$i]) || $expected[$i] != $json[$i]['content']){
                $err = 1;
            }
        }
    }
    else{
        $msg .= "<div>База данных недоступна</div>";
        echo mysqli_error($conn);
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