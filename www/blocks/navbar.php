<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6A94D4">
  <a style="padding-left: 150px;" class="navbar-brand" href="/">СДО ВИТ</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?
  $optionarr = array();
    if (isset($userInfo))
      if($userInfo["permissions"] == '0'){
        $optionarr['Пользователи'] = 'addUsers.php';
        $optionarr['Группы'] = 'groups.php';
      }
      else{
        $optionarr['Доски'] = 'showBoards.php';
        $optionarr['Чаты'] = 'chats.php';
      }
  ?>
  <div class="collapse navbar-collapse" id="navbarContent">
    <? if (sizeof($optionarr) != 0) { ?>
    <ul class="navbar-nav">
      <? foreach ($optionarr as $key => $value) {?>
      <li class="nav-item">
        <a class="nav-link" href="<? echo $value; ?>"><? echo $key; ?></a>
      </li>
      <? } ?>
      <li class="nav-item">
        <a class="nav-link" href="/actions/logout.php">Выйти</a>
      </li>
    </ul>
    <? } ?>
  </div>
</nav>