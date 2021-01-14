<?
   require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
   require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

if(isset($_POST["data"]) && isset($_POST["pass"]))
  $logConfirm=checkLogInfo($_POST["data"], $_POST["pass"]);
else
  $logConfirm=false;

if(is_array($logConfirm) && $logConfirm['logStatus'] == true) {
    $_SESSION["logUser"]=$_POST["data"];
    header("Location: $FULL_SITE_PATH/chats.php");
}
else {
    if(is_array($logConfirm))
        $errorStr=$logConfirm["status_string"];
    else
        $errorStr="Не заданы логин и пароль";
    //include($_SERVER["DOCUMENT_ROOT"]."/pages/errorlog/index.php");
      echo $errorStr;
    unset($_SESSION["logUser"]);
}
?>