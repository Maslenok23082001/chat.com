<?php
session_start();
?>
<?php
require_once "blocks/header.php";
?>
<body>
<?php if(!(isset($_SESSION['user']))): ?>
<p id="p_login">войдите             или               зарегистрируйтесь</p>
<form action="" method="post" id="vhod">
    <label for="log_in">введите логин: </label><br>
    <input type="text" class="log_in" style="    width: 204px;
    margin: 0 auto;
    display: block;
    margin-top: 24px;
    height: 34px;
    font-size: 20px;
    padding-left: 5px;
    border: none;
    border-radius: 9px;" name="login"/><br>
    <label for="password">введите пароль: </label><br>
    <input type="password" class="password" name="password"/>
    <input type="submit" id="vhod_done" name="vhod_done" value="Войти"/>
</form>
    <form action="" method="post" id="reg">
        <label for="log_in">введите логин: </label><br>
        <input type="text" class="log_in" style="    width: 204px;
    margin: 0 auto;
    display: block;
    margin-top: 24px;
    height: 34px;
    font-size: 20px;
    padding-left: 5px;
    border: none;
    border-radius: 9px;" name="login_reg"/><br>
        <label for="password">введите пароль: </label><br>
        <input type="password" class="password" name="password_reg"/>
        <label for="name_reg">введите имя: </label><br>
        <input type="text" id="name_reg" name="name_reg"/>
        <label for="family_reg">введите фамилию: </label><br>
        <input type="text" id="family_reg" name="family_reg"/>

        <input type="submit" id="reg_done" name="reg_done" style="width: 223px;
    height: 100px;
    border: none;
    border-radius: 50%;
    margin: 0 auto;
    display: block;
    margin-top: 38px;
    color: #111;
    font-size: 21px;
    font-family: fantasy;
    cursor: pointer;" value="зарегистрироваться"/>
    </form>
<?php endif; ?>
<?php if(isset($_SESSION['user'])): ?>
    <div id="user">
        <div id="image_user"></div>
        <div id="name_user"><?=$_SESSION['name_user']?></div>
        <form action="" id="vihod" method="post">
            <input type="submit" name="vihod" id="vihod" value="выйти"/>
        </form>
    </div>
    <a href="group_chat.php" id="a_group_chat">групповой чат</a>
    <a href="ls.php" id="a_ls">личные сообщения</a>

<?php endif; ?>
</body>
</html>