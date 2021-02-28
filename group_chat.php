<?php
require_once "blocks/header.php";
?>


<body>
<?php
if(!(isset($_SESSION['user']))):
    ?>
    чтобы войти в групповой чат вам необходимо <a href="index.php">войти</a>

<?php endif; ?>
<?php if(isset($_SESSION['user'])): ?>
    <a style="    position: absolute;
    top: 36px;
    left: 6%;" href="group_chat.php">групповой чат</a>
    <a style="    position: absolute;
    top: 36px;
    left: 15%;" href="ls.php">личные сообщения </a>

    <div id="user">
        <div id="image_user"></div>
        <div id="name_user"><?=$_SESSION['name_user']?></div>
        <form action="" id="vihod" method="post">
            <input type="submit" name="vihod" id="vihod" value="выйти"/>
        </form>
    </div>

    <div style="padding: 100px; padding-top: 5px; padding-bottom: 10px;">
        <h1 style="    font-size: 21px;
    padding-top: 10px;
    padding-bottom: 10px;">Групповой чат</h1>


        <div class="chat r4">
            <div id="chat_area"></div>
        </div>
        <div class="users_online">
            <span style="padding-left: 6%;"> online</span>
            <ul>

            </ul>
        </div>
        <form id="pac_form" action="">

            <td><input type="text" id="pac_name" class="r4" value="<?=$_SESSION['name_user']?>" readonly></td>


            <td style="width: 80%;"><input type="text" id="pac_text" class="r4" value=""></td>


            <td><input id="otp" type="submit" value="ОТПРАВИТЬ"></td>
            </tr>
            </table>
        </form>

    </div>
<?php endif; ?>
</body>
</html>