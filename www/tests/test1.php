<?
	$regInfo = array();
	$msg = "<div>Попытка зарегистрировать пользователя с данными:</div>";

	$regInfo["login"] = "wui";
    $regInfo["name"] = "Name";
    $regInfo["surname"] = "Surname";
    $regInfo["middlename"] = "Middlename";
	$regInfo["birthdate"] = "2020-01-12";
    $regInfo["groupid"] = "VVT-406";
    $regInfo["idcard"] = "123456";
    $regInfo["pass"] = "123";
    $regInfo["passconf"] = "123";

    foreach($regInfo as $k => $v){
    	$msg .= "<div>$k = $v</div>";
    }

    $err = 0;
    $status = checkRegUserInfo($regInfo);
    if($status == 'ok')
    	$msg .= "<div>Данные могут быть использованы для регистратции</div>";
    else{
    	$msg .= "<div>Ошибка при проверке данных: $status</div>";
    	$err = 1;
    }
    if(!$err && saveUserInfo(saveUserInfo($regInfo)))
    	$msg .= "<div>Пользователь успешно зарегистрирован</div>";
    else{
    	$msg .= "<div>Не удалось зарегистрировать пользователя</div>";
    	$err = 1;
    }

    if(!$err)
    {
    	mysqli_query($conn, "DELETE FROM user WHERE login = '".$regInfo["login"]."'");
    	echo mysqli_error($conn);
    }

    array_push($content, $msg);
    if($err) array_push($res, 'failure');
    else array_push($res, 'success');
?>