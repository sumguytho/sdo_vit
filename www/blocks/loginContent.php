<div class="container-fluid">
    <form method="post" action="/actions/login.php" class="submitForm">
    	<h1>Авторизация</h1>
        <input id="data" name="data" placeholder="Логин или e-mail" type="text" autofocus/>
        <input id="pass" name="pass" type="password" placeholder="Пароль" required/>

        <input style="margin-top: 20px; margin-bottom: 20px;" class="blueBtn" type="submit" value="Войти" />
        <button style="margin-top: 20px; margin-bottom: 20px;" type="button" onclick="location.href = '/register.php';" action="" class="whiteBtn">Зарегистрироваться</button>
    </form>
</div>