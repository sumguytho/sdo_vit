<?
	$msg = "<div>Попытка получить список досок для группы ВИП-408:</div>";
    $msg .="<div>Ожидаемый результат:</div>";
    $expected = array();
    $expected[0] = "доска1";
    $expected[1] = "доска2";

    foreach($expected as $el){
        $msg .= "<div>".$el."</div>";
    }

    $u['idUser'] = 0;
    $u['groupId'] = 1;
    $status = getDeskList($u);
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