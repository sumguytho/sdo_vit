<?
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/scripts/service.php");
?>
<!DOCTYPE html>
<html>
<head>
  <? 
  	$pageTitle = "";
  	require_once($_SERVER["DOCUMENT_ROOT"]."/blocks/htmlHeader.php");
  ?>
</head>
<body>
<?
	$content = array();
	$res = array();
	$conn = connect_db($db_param);

	include('test1.php');
	include('test2.php');
	include('test3.php');
	include('test4.php');
	include('test5.php');
	include('test6.php');
	include('test7.php');
	include('test8.php');

	mysqli_close($conn);
	for($i = 0; $i < count($content); $i++){
		$val = $content[$i];
		$class = $res[$i] == 'success' ? 'alert alert-success' : 'alert alert-danger';
		echo "<div class=\"$class\">$val</div>";
	}
?>	
</body>
</html>