<?
   require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
   require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");

   $status=checkRegUserInfo($_POST);

   if($status=="ok"){
        if(saveUserInfo($_POST))
         header("Location: $FULL_SITE_PATH"."/register.php?status="."success");
       else
         header("Location: $FULL_SITE_PATH"."/register.php?status=Ошибка сохранения информации в базе данных");
   }
   else
       header("Location: $FULL_SITE_PATH"."/register.php?status=".$status);

?>