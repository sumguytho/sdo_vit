<?
    $msg = "<div>Попытка войти с данными:</div>";
    $login = "ll@.ru";
	$pass = "123";
    $msg .="<div>login = $login</div><div>pass = $pass</div>";

    $status = checkLogInfo($login, $pass);
    $err = 0;

    if(is_array($status)){
        if($status['logStatus'])
            $msg .= "<div>Вход выполнен успешно</div>";
        else{
            $msg .= "<div>Вход не удался: ".$status['status_string']."</div>";
            $err = 1;
        }
    }
    else{
        $msg .= "<div>База данных недоступна</div>";
        $err = 1;
    }

    array_push($content, $msg);
    if($err) array_push($res, 'failure');
    else array_push($res, 'success');
?>