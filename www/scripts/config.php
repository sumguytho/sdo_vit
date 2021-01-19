<?
session_start();
if ( !ini_get( 'display_errors' ) ) {
    ini_set( 'display_errors', 1 );
}
ini_set( 'log_errors', 0 );

$SITE_PATH="/b68afdcff4e8.ngrok.io";
$FULL_SITE_PATH="http://b68afdcff4e8.ngrok.io";
$LOCAL_PATH=$_SERVER["DOCUMENT_ROOT"];

$db_param=array();
$db_param["server"]="localhost";
$db_param["base"]="sdo_vit";
$db_param["user"]="root";
$db_param["pass"]="1234";
?>