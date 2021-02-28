<?php
session_start();
?>
<?php
require_once "bd.php";
require_once "functions.php";
?>
<?php

if (isset($_POST['vhod_done'])) {
    unset($_SESSION['user']);
    unset($_SESSION['id_user']);
    unset($_SESSION['name_user']);
    if ($_POST['login'] != "" && $_POST['login'] != " ") {
        $login = $_POST['login'];


    }
    if ($_POST['password'] != "" && $_POST['password'] != " ") {
        $password = $_POST['password'];

    }
    $result = get_user($login);
    $row = $result->fetch_assoc();


    if ($row['password'] == $password) {
        $_SESSION['user'] = $login;
        $_SESSION['id_user'] = $row['id'];
        $_SESSION['name_user'] = $row['name']." ".$row['family'];


    }
    else {
        echo "не удаётся войти";
    }
}
if (isset($_POST['reg_done'])) {
    unset($_SESSION['user']);
    unset($_SESSION['id_user']);
    unset($_SESSION['name_user']);
    if ($_POST['login_reg'] != "" && $_POST['login_reg'] != " ") {
        $login_reg = $_POST['login_reg'];


    }
    if ($_POST['password_reg'] != "" && $_POST['password_reg'] != " ") {
        $password_reg = $_POST['password_reg'];

    }
    if ($_POST['name_reg'] != "" && $_POST['name_reg'] != " ") {
        $name_reg = $_POST['name_reg'];

    }
    if ($_POST['family_reg'] != "" && $_POST['family_reg'] != " ") {
        $family_reg = $_POST['family_reg'];

    }
    $us = set_user($login_reg, $password_reg, $name_reg, $family_reg);
    if($us) {
        $userss = get_user_pass_log($login_reg, $password_reg);
        $rowq = $userss->fetch_assoc();

        $_SESSION['user'] = $login_reg;
        $_SESSION['id_user'] = $rowq['id'];
        $_SESSION['name_user'] = $name_reg." ".$family_reg;
    }





}
if (!(isset($_POST['ls']))) {
    $user1 = $_GET['user1'];
    $user2 = $_GET['user2'];
    $result4 = get_room($user1, $user2);
    $result5 = get_room($user2, $user1);
    if($result4->num_rows == 1 ) {
        $room = $result4;
    }
    else if ($result5->num_rows == 1 ) {
        $room = $result5;
    }

    else {
        $room = set_room($user1, $user2);
    }
    $rom = $room->fetch_assoc();
    $room_id = $rom['id'];

}

if(isset($_POST['vihod'])) {
    offline_user($_SESSION['id_user']);
    unset($_SESSION['user']);
    unset($_SESSION['id_user']);
    unset($_SESSION['name_user']);

    header("Location:index.php");

}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>PhpAjaxChat</title>
    <!-- � ��� �� �������� � UTF-8 -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <!-- ��������� ����� ��� ���� -->
    <link rel="stylesheet" type="text/css" media="screen" href="../public/css.css" />

    <!-- ���������� jQuery -->
    <script type="text/javascript" src="../public/jquery.js"></script>

    <!-- ��� ��� ������ ���� -->
    <script type="text/javascript">

        $(document).ready(function () {
            $(".user_dialog .a_chs").click(function(e){
                var id_n = $(this).attr("data-num");
                var p = $(this).parent();
                $.ajax( {
                    url: "chs.php",
                    type: "POST",
                    data: {
                      id: <?=$_SESSION['id_user'];?>,
                      id2: id_n
                    },
                    dataType: "html",
                    success: function (data) {
                        p.find(".a_chs").css("display", "inline");
                        p.find(".del_chs").css("display", "inline");
                    }
                });


            });
            $(".user_dialog .del_chs").click(function(e){
                var id_n = $(this).attr("data-num");
                var p = $(this).parent();
                $.ajax( {
                    url: "del_chs.php",
                    type: "POST",
                    data: {
                        id: <?=$_SESSION['id_user'];?>,
                        id2: id_n
                    },
                    dataType: "html",
                    success: function (data) {
                        p.find(".a_chs").css("display", "inline");
                        p.find(".del_chs").css("display", "inline");
                    }
                });


            });


            setInterval(function(){
                $.ajax( {
                    url: "online.php",
                    type: "POST",
                    dataType: "html",
                    success: function (data) {
                        $(".users_online ul").html(data);
                    }
                });
            }, 5000);
            setInterval(function(){
                $.ajax( {
                    url: "ls_load.php",
                    type: "POST",
                    data: {
                        room_id:<?=$room_id;?>,
                        id_us:<?=$_SESSION['id_user']?>
                    },
                    dataType: "html",
                    success: function (data) {
                        $("#chat_area_ls").html(data);
                        $(".chat_ls").scrollTop($(".chat_ls").get(0).scrollHeight);
                    }
                });
            }, 1000);
            setInterval(function(){
                $.ajax( {
                    url: "m_load.php",
                    type: "POST",

                    dataType: "html",
                    success: function (data) {
                        $("#chat_area").html(data);
                    }
                });
            }, 1000);

            $("#pac_form").submit(Send); // ������ �� ����� � ������ � ���������� ������� ������� ����������� ����� ������ ������ "���������" ��� "Enter"
            // ������ �� ����� � ������ � ���������� ������� ������� ����������� ����� ������ ������ "���������" ��� "Enter"
            $("#pac_text").focus(); // �� ���� ����� ��������� ������ �����
            setInterval(Load(), 2000);

            // ������ ������ ������� ����� �������� �������� ��������� ������ 2 ������� (2000 �����������)
            $("#pac_form_ls #otp").click(function(e){

                $.post("ajax.php",
                    {
                        act: "send_ls",
                        room_id: <?=$room_id?>,
                        id_us: <?=$_SESSION['id_user'];?>,
                        name: $("#pac_name_ls").val(), // ��� ������������
                        text: $("#pac_text_ls").val() //  ��� ����� ���������
                    },
                    function () {
                        $(".chat_ls").scrollTop($(".chat_ls").get(0).scrollHeight);
                    } ); // �� ���������� �������� �������� ������� �������� ����� ��������� Load()

                $("#pac_text_ls").val(""); // ������� ���� ����� ���������
                $("#pac_text_ls").focus(); // � �������� �� ���� �����
                $("#pac_text_ls").focus(); // �� ���� ����� ��������� ������ �����

                return false;
                $("#pac_text_ls").focus(); // �� ���� ����� ��������� ������ �����

                // ����� ����� �� Send() ������� false. ���� ����� �� ������� �� ��������� �������� ����� �����, �� �������� ��������������

            });
        });
        function ls(room_id) {

            $.ajax( {
                url: "ls_load.php",
                type: "POST",
                data: {room_id : room_id},
                dataType: "html",
                success: function (data) {
                    $("#chat_area_ls").html(data);
                }
            });
        }



        // ������� ��� �������� ���������
        function Send() {
            // ��������� ������ � ������� � ������� jquery ajax: $.post(�����, {��������� �������}, ������� ������� ���������� �� ���������� �������)
            $.post("ajax.php",
                {
                    act: "send",  // ��������� �������, ��� �� ���������� ����� ��������� � ��� ����� ��������
                    name: $("#pac_name").val(), // ��� ������������
                    text: $("#pac_text").val() //  ��� ����� ���������
                },
                Load ); // �� ���������� �������� �������� ������� �������� ����� ��������� Load()

            $("#pac_text").val(""); // ������� ���� ����� ���������
            $("#pac_text").focus(); // � �������� �� ���� �����

            return false; // ����� ����� �� Send() ������� false. ���� ����� �� ������� �� ��������� �������� ����� �����, �� �������� ��������������
        }

        var last_message_id = 0; // ����� ���������� ���������, ��� ������� ������������
        var load_in_process = false;


        // ����� �� �� ��������� ������ �������� ���������. ������� ����� false, ��� ������ - ��, �����
        setInterval(function(){
            if (window.location.pathname == "/group_chat.php") {

                $.post("ajax.php", {
                    act: "onl",
                    id: <?=$_SESSION['id_user']?>,
                    line: "online"
                });
            }
            else {
                $.post("ajax.php", {
                    act: "ofl",
                    id: <?=$_SESSION['id_user']?>,
                    line: "offline"
                });
            }

        }, 5000)
        // ������� ��� �������� ���������
        function Load() {
            // ��������� ����� �� �� ��������� ���������. ��� ������� ��� ����, ����� �� �� ������ �������� ������, ���� ������ �������� �� �� �����������.
            if(!load_in_process)
            {
                load_in_process = true; // �������� ��������
                // �������� ������ �������, ������� ����� ��� javascript
                $.post("ajax.php",
                    {
                        act: "load", // ��������� �� �� ��� ��� �������� ���������
                        last: last_message_id, // ������� ����� ���������� ��������� ������� ������� ������������ � ������� ��������
                        rand: (new Date()).getTime()
                    },
                    function (result) { // � ��� ������� � �������� ��������� ��������� javascript ���, ������� �� ������ ���������
                        $(".chat").scrollTop($(".chat").get(0).scrollHeight); // ������������ ��������� ����
                        load_in_process = false; // ������� ��� �������� �����������, ����� ������ ������ ����� ��������
                    });
            }
        }



    </script>
</head>