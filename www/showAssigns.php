<?
	include("scripts/config.php");
	include("scripts/service.php");
?>
<!DOCTYPE html>
<html>
<head>
  <? 
  	$pageTitle = "СДО ВИТ просмотр заданий доски";
  	require_once("blocks/htmlHeader.php");
  ?>
</head>
<body class="alt-bg">
<?
	include("blocks/navbar.php");
	if(isset($_GET['id']))
		include("blocks/assignList.php");
?>	
</body>
</html>
