<?
	include("scripts/config.php");
	include("scripts/service.php");
?>
<!DOCTYPE html>
<html>
<head>
  <? 
  	$pageTitle = "СДО ВИТ просмотр досок";
  	require_once("blocks/htmlHeader.php");
  ?>
</head>
<body class="alt-bg">
<?
	include("blocks/navbar.php");
	include("blocks/boardList.php");
?>	
</body>
</html>
