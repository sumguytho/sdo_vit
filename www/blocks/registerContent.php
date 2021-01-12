<script type="text/javascript">
	$(function(){
		$('#birthdate').datepicker({
			changeMonth: true,
      		changeYear: true,
      		dateFormat: "yy-mm-dd",
      		yearRange: "-150:+0"});
	});
</script>
<div class="container-fluid">
	<form class="submitForm" action="/actions/register.php" method="post">
		<h1>Регистрация</h1>
		<? if (isset($_GET["status"])) {?>
		<div style="width:400px; margin:auto;" class="alert <? if ($_GET['status'] == 'success') { echo 'alert-success'; $_GET['status'] = 'Регистрация прошла успешно'; } else echo 'alert-danger'; ?>" role="alert">
  			<? echo $_GET["status"]; ?>
		</div>
		<? } ?>
		<input id="name" name="name" type="text" placeholder="Имя" autofocus required/>
	    <input id="surname" name="surname" type="text" placeholder="Фамилия"  required/>
	    <input id="middlename" name="middlename" type="text" placeholder="Отчество"  required/>
	    <input id="birthdate" name="birthdate" type="text" placeholder="Дата рождения"/>
	    <input id="groupid" name="groupid" placeholder="Группа" list="groups-list" required>
		<datalist id="groups-list">
		  <option value="ВИП-408"></option>
		  <option value="ВВТ-406"></option>
		</datalist>
	    <input id="idcard" name="idcard" type="text" placeholder="Номер зачетки"  required/>
	    <input id="login" name="login" type="text" placeholder="Логин"  required/>
	    <input id="mail" name="mail" placeholder="E-mail" type="email"/>
	    <input id="pass" name="pass" type="password" placeholder="Пароль" required/>
	    <input id="passconf" name="passconf" type="password" placeholder="Подтверждение пароля" required/>
	    <input class="blueBtn" type="submit" value="Зарегистрироваться" />
	    <div class="blueLine"></div>
    	<a style="padding-bottom: 150px;" href="/login.php">Уже есть аккаунт? Войти</a>
    </form>
</div>