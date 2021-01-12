    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? echo $pageTitle; ?></title>

    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.js"></script>
    <? if(isset($_SESSION["logUser"]))  $userInfo = getUserInfo($_SESSION["logUser"]); /*нужно для некоторых частей*/ ?>
