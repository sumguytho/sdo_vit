<?
	require_once("scripts/config.php");
	require_once("scripts/service.php");

	if(isset($_SESSION['logUser'])) {
		$user = getUserInfo($_SESSION['logUser']);
		if($user)
			if($user['permissions'] == '0')
				header("Location: $FULL_SITE_PATH"."/addUsers.php");
			else
				header("Location: $FULL_SITE_PATH"."/showBoards.php");
	}
	else header("Location: $FULL_SITE_PATH"."/login.php");
?>