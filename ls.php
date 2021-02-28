<?php
require_once "blocks/header.php";
$result = get_users($_SESSION['id_user']);
?>


<body>
<?php
if(!(isset($_SESSION['user']))):
    ?>
    чтобы войти в личные сообщения вам необходимо <a href="index.php">войти</a>

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

        <ul id="users_list">
            <?php while($row=$result->fetch_assoc()): ?>
                <?php if($row['id'] != $_SESSION['id_user']): ?>
            <li class="user_dialog">
                <span style="display: block;">
                <?=$row['family']." ".$row['name']?>
                    </span>
                <a href="dialogroom.php?user1=<?=$_SESSION['id_user']?>&user2=<?=$row['id']?>" class="a_sms"><span style="width: 20px;"></span>написать сообщение</a>
                <a href="#" class="a_chs" data-num="<?=$row['id']?>" style="    margin-left: 37px;">добавить в черный список</a>
                <a href="#" class="del_chs" data-num="<?=$row['id']?>" style="     margin-left: 67px; display: inline;">удалить из черного списка</a>
            </li>
                    <?php endif; ?>
            <?php endwhile; ?>
        </ul>

<?php endif; ?>
</body>
</html>

