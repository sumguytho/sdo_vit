<?
	$msg = "<div>Попытка получить список чатов для пользователя asd asd:</div>";
    $msg .="<div>Ожидаемый результат:</div>";
    $expected = array();
    $expected[0] = "Второй чаи";
    $expected[1] = "новый чат";

    foreach($expected as $el){
        $msg .= "<div>".$el."</div>";
    }

    $sql = "SELECT
  chat_membership.userId,
  chat.name,
  chat.chatId
FROM chat_membership
  INNER JOIN chat
    ON chat_membership.chatId = chat.chatId
    WHERE chat_membership.userId = '6'";

    $result = mysqli_query($conn, $sql);
    $status = array();

    while($row = $result->fetch_assoc()){
        $status[] = $row;
    }

    $err = 0;

    if(is_array($status)){
        $msg .= "<div>Реальный результат:</div>";
        for($i = 0; $i < count($status); $i++){
            $msg .= "<div>".$status[$i]['name']."</div>";
            if(!isset($expected[$i]) || $expected[$i] != $status[$i]['name']){
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