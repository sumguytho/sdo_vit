<?php
function checkRegUserInfo($regInfo)
{
    global  $LOCAL_PATH;;
    $status = "";
    if (!isset($regInfo["login"]) || isset($regInfo["login"]) && !checkRegExp($regInfo["login"], "login") )
        $status = "логин, ";

    if (!isset($regInfo["name"]) || isset($regInfo["name"]) && !checkRegExp($regInfo["name"], "name"))
        $status .= "имя, ";
    if (!isset($regInfo["surname"]) || isset($regInfo["surname"]) && !checkRegExp($regInfo["surname"], "surname"))
        $status .= "фамилия, ";
    if (!isset($regInfo["middlename"]) || isset($regInfo["middlename"]) && !checkRegExp($regInfo["middlename"], "middlename"))
        $status .= "отчество, ";
	if (!isset($regInfo["birthdate"]) || isset($regInfo["birthdate"]) && !checkRegExp($regInfo["birthdate"], "birthdate"))
        $status .= "дата рождения, ";

    if (!isset($regInfo["groupid"]) || isset($regInfo["groupid"]) && !checkRegExp($regInfo["groupid"], "groupid"))
        $status .= "группа, ";
    if (!isset($regInfo["idcard"]) || isset($regInfo["idcard"]) && !checkRegExp($regInfo["idcard"], "idcard"))
        $status .= "номер зачетной книжки, ";
   
    if (!isset($regInfo["birthdate"]) || isset($regInfo["mail"]) && $regInfo["mail"]!="" && !checkRegExp($regInfo["mail"], "mail"))
        $status .= "адрес почты, ";
    if (!isset($regInfo["pass"]) || isset($regInfo["pass"]) && !checkRegExp($regInfo["pass"], "pass"))
        $status .= "пароль, ";
    if (!isset($regInfo["passconf"]) || !isset($regInfo["pass"]) || isset($regInfo["pass_conf"]) &&
        isset($regInfo["pass"]) && $regInfo["passconf"] != $regInfo["pass"])
           $status .= "неверное подтверждение пароля, ";

    global $FULL_SITE_PATH;
    if (isset($regInfo["login"]) && getUserInfo($regInfo["login"])!=null)
       $status .= "уже есть такой логин, ";

    if($status=="")
       return "ok";
    else
        return "Указаны неверные данные: ".substr($status,0,-2);
}


function checkRegExp($str, $template)
{
    switch($template)
    {
        case "login":
            return preg_match("/^[a-zA-Z0-9_]{1,10}$/u", $str);

        case "pass":
            return preg_match("/^[a-zA-Z0-9_]{1,20}$/u",$str);

        case "mail":
            return preg_match("/^[\-\._a-z0-9]+@(?:[a-z0-9][\-a-z0-9]+\.)+[a-z]{2,6}$/u",$str);

        case "name":
        case "surname":
        case "middlename":
            return preg_match("/^[А-ЯЁ][а-яё]{1,20}$/u",$str);


        case "birthdate":
            return preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/u",$str);

        case "groupid":
            return preg_match("/^[А-Я]{3}-[0-9]{3}$/u", $str);

        case "idcard":
            return preg_match("/^[0-9]{6}$/u", $str);

       default:
            return false;

    }
}


function checkLogInfo($log, $pas)
{
    global $db_param;
    $status = array();
    $paramtype = "";
    if (checkRegExp($log, "login"))
    	$paramtype = 'login';
    else if (checkRegExp($log, "mail"))
    	$paramtype = 'mail';

    if ($paramtype == "" || !checkRegExp($pas, "pass")) {
        $status["logStatus"] = false;
        $status["status_string"] = "Некорректные логин (почта) или пароль";
        return $status;
    }
    $conn = connect_db($db_param);

    if ($conn) {
        $query = "call authUser(\"$log\", \"$pas\", \"$paramtype\")";
        $result = mysqli_query($conn, $query);
        $responce = $result->fetch_assoc();
        $responce = $responce["ack"];

        if ($responce > 0)
                 $status["logStatus"] = true;
        else {
            $status["logStatus"] = false;
            $status["status_string"] = "Неверные логин или пароль";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        return $status;
    }
}


//**//**//**//**//**//**//**//**//**//
function getUserInfo($logUser)
{
    global $db_param;

    if (!checkRegExp($logUser, "login"))
        return null;

    $conn = connect_db($db_param);
    $query = "call getUserByLogin(\"{$logUser}\")";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0){  
    	$userInfo = mysqli_fetch_assoc($result);
    }
    else {
      $userInfo=null;
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    return $userInfo;
}


function saveUserInfo($userInfo)
{
    global $db_param;

    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "call addUser(\"{$userInfo["name"]}\", \"{$userInfo["surname"]}\", \"{$userInfo["middlename"]}\", \"{$userInfo["birthdate"]}\", \"{$userInfo["idcard"]}\", \"{$userInfo["mail"]}\", \"{$userInfo["pass"]}\", \"{$userInfo["login"]}\", \"3\", \"{$userInfo["groupid"]}\")";
        $result = mysqli_query($conn, $query);
        
        if($result){
            $responce = $result->fetch_assoc();
            mysqli_free_result($result);
            mysqli_close($conn);
            return $responce['res'];
        }
        else mysqli_close($conn);
    }
    return false;
}


function getDeskList($userInfo){
    global $db_param;

    $conn = connect_db($db_param);
    if ($conn != null) {
        $query = "call getDesks(\"{$userInfo["idUser"]}\", \"{$userInfo["groupId"]}\")";
        $result = mysqli_query($conn, $query);
        
        if($result){
            $resarr = array();
            while($row = $result->fetch_assoc()) array_push($resarr, $row);

            mysqli_free_result($result);
            mysqli_close($conn);
            return $resarr;
        }
        else mysqli_close($conn);
    }
    return false;
}


function connect_db($db_param)
{
    $conn = mysqli_connect($db_param["server"], $db_param["user"], $db_param["pass"], $db_param["base"]);
    if ($conn) mysqli_set_charset($conn, "utf8");
    return $conn;
}
?>