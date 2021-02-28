<?php
require_once "blocks/header.php";
if (!(isset($_POST['ls']))) {
    $user1 = $_GET['user1'];
    $user2 = $_GET['user2'];
    $user_to = get_userid($user2);
    $user_to2 = $user_to->fetch_assoc();
    $result1 = get_room($user1, $user2);
    $result2 = get_room($user2, $user1);
    if($result1->num_rows == 1 ) {
        $room = $result1;
    }
    else if ($result2->num_rows == 1 ) {
        $room = $result2;
    }

    else {
        $room = set_room($user1, $user2);
    }
    $rom = $room->fetch_assoc();
    $room_id = $rom['id'];
    $room_user1 = $rom['user1'];
    $room_user2 = $rom['user2'];
    if ($rom['chs'] == 'true') {
        $chs = true;
    }
    else {
        $chs = false;
    }

    $_SESSION['user2_name'] = $user_to2['name']." ".$user_to2['family'];

}


?>


<body>
<?php
if(!(isset($_SESSION['user']))):
    ?>
    чтобы войти в личные сообщения вам необходимо <a href="index.php">войти</a>

<?php endif; ?>
<?php if($chs == true): ?>
для начала удалите его из чёрного списка

<?php endif; ?>
<?php if($chs == false): ?>
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

<?php endif; ?>

<div style="    padding: 206px;
    padding-top: 5px;
    padding-right: 0px;
    padding-bottom: 10px;">
    <h1 style="    font-size: 21px;
    padding-top: 10px;
    padding-bottom: 10px;"></h1>

        <div style="    width: 53%;
    background-color: #878;
    height: 45px;
    font-size: 33px;
    margin-top: -17px;
    color: #fff;
    letter-spacing: 15px;
    padding-left: 57px;
    border-radius: 5px 5px 5px 5px;"><?=$_SESSION['user2_name']?></div>

    <div style="height: 500px;
        overflow: auto; /* ��� ��������� ���������� ������ ��������� */
        position: relative; /* ��� ��������� �������� ������ � ����, �� ���������� �������� */
        text-align: left;
        border: solid #818181 1px;
        padding: 20px;
        background-color: steelblue;
        font-size: 17px;
        width: 54%;" class="chat_ls r4">

        <div id="chat_area_ls"></div>
    </div>

    <div id="pac_form_ls">

        <td><input type="text" style="display:none;" id="pac_name_ls" class="r4" value="<?=$_SESSION['name_user']?>" readonly></td>


        <td style="width: 80%;"><input style="width:50%;" type="text" id="pac_text_ls" class="r4" value=""></td>


        <td><input id="otp"  type="submit" value="ОТПРАВИТЬ"></td>
        </tr>
        </table>
    </div>

</div>

<?php endif; ?>








</body>
</html>

