<?php
require_once "blocks/functions.php";
// ��������� ��� ����������� � MySQl
$config = array('hostname' => 'localhost', 'username' => 'root', 'password' => '', 'dbname' => 'asd');

// ������������ � MySQL, ���� �� ����� �� �������
if (!mysql_connect($config['hostname'], $config['username'], $config['password'])) {
    exit();
}
// �������� ���� ������, ���� �� ����� �� �������
if (!mysql_select_db($config['dbname'])) {
    exit();
}
mysql_query("SET NAMES 'utf8'"); // ������� MySQl'� �� ��� �� ����� �������� � UTF-8

Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");

Header("Content-Type: text/javascript; charset=utf-8"); // ������� �������� ��� ��� javascript � ��������� UTF-8

// ��������� ���� �� ���������� act (send ��� load), ������� ��������� ��� ��� ������
if (isset($_POST['act'])) {
    // $_POST['act'] - ����������
    switch ($_POST['act']) {
        case "send" : // ���� ��� ��������� send, �������� ������� Send()
            Send();
            break;
        case "load" : // ���� ��� ��������� load, �������� ������� Load()
            Load();
            break;

        case "send_ls" : // ���� ��� ��������� load, �������� ������� Load()
            send_ls();
            break;

        case "onl" :
            Online();
            break;
        case "ofl" :
            Offline();
            break;
        default : // ���� �� ���� � �� �������  - �������
            exit();
    }
}

// ������� ��������� ���������� ��������� � ���� ������
function Send()
{
    // ��� �� �������� ��� ���������� ���������� ����� java-�������� ��� ������ ajax
    // ���:  $_POST['name'] - ��� ������������
    // � $_POST['text'] - ���������

    $name = substr($_POST['name'], 0, 200); // �������� �� 200 ��������
    $name = htmlspecialchars($name); // �������� ������� ���� (<h1>,<br>, � ������) �� ����������
    $name = mysql_real_escape_string($name); // ������� ���������� ��� ����-������� � unescaped_string , ���������� ����, � ����� ��������� ������������ � mysql_query()

    $text = substr($_POST['text'], 0, 200); // �������� �� 200 ��������
    $text = htmlspecialchars($text); // �������� ������� ���� (<h1>,<br>, � ������) �� ����������
    $text = mysql_real_escape_string($text); // ������� ���������� ��� ����-������� � unescaped_string , ���������� ����, � ����� ��������� ������������ � mysql_query()

    // ��������� ����� ������ � ������� messages
    mysql_query("INSERT INTO messages (name,text) VALUES ('" . $name . "', '" . $text . "')");
}
function send_ls()
{
    // ��� �� �������� ��� ���������� ���������� ����� java-�������� ��� ������ ajax
    // ���:  $_POST['name'] - ��� ������������
    // � $_POST['text'] - ���������

    $name = substr($_POST['name'], 0, 200); // �������� �� 200 ��������
    $name = htmlspecialchars($name); // �������� ������� ���� (<h1>,<br>, � ������) �� ����������
    $name = mysql_real_escape_string($name); // ������� ���������� ��� ����-������� � unescaped_string , ���������� ����, � ����� ��������� ������������ � mysql_query()

    $text = substr($_POST['text'], 0, 200); // �������� �� 200 ��������
    $text = htmlspecialchars($text); // �������� ������� ���� (<h1>,<br>, � ������) �� ����������
    $text = mysql_real_escape_string($text); // ������� ���������� ��� ����-������� � unescaped_string , ���������� ����, � ����� ��������� ������������ � mysql_query()

    // ��������� ����� ������ � ������� messages
    mysql_query("INSERT INTO messages (name,text,room_id,id_us) VALUES ('" . $name . "', '" . $text . "', '".$_POST['room_id']."', '".$_POST['id_us']."')");
}


function Online() {
    $id = $_POST['id'];
    $online = $_POST['line'];

    $result = mysql_query("UPDATE `users` SET  `line` =  'online' WHERE `id` = ".$id."");
}

function Offline() {
    $id = $_POST['id'];
    $online = $_POST['line'];

    $result = mysql_query("UPDATE `users` SET  `line` =  'offline' WHERE `id` = ".$id."");
}




// ������� ��������� �������� ��������� �� ���� ������ � �������� �� ������������ ����� ajax ���� java-�������
//function Load()
//{
//    // ��� �� �������� ���������� ���������� ����� java-�������� ��� ������ ajax
//    // ���:  $_POST['last'] - ����� ���������� ��������� ������� ����������� � ������������
//
////    $last_message_id = intval($_POST['last']); // ���������� ����� �������� ����������
//
//    // ��������� ������ � ���� ������ ��� ��������� 10 ��������� ��������� ��������� � ������� ������� ��� $last_message_id
//    $query = mysql_query("SELECT * FROM messages  ORDER BY id DESC LIMIT 30");
//
//    // ��������� ���� �� �����-������ ����� ���������
//    if (mysql_num_rows($query) > 0) {
//        // �������� ����������� javascript ������� �� ��������� �������
//        $js = 'var chat = $("#chat_area");'; // �������� "���������" �� div, � ������� �� ������� ����� ���������
//
//        // ��������� ������������ �� �������� ������ ��������� �� ������ �������
//        $messages = array();
//        while ($row = mysql_fetch_array($query)) {
//            $messages[] = $row;
//        }
//
//        // ���������� ����� ���������� ���������
//        // [0] - ��� ����� ��� ������ ������� � ������� $messages, �� ��� ��� �� ��������� ������ � ���������� "DESC" (� �������� �������),
//        // �� ��� ���������� ����� ���������� ��������� � ���� ������
//
//
//        // �������������� ������ (������ �� � ���������� �������)
//        $messages = array_reverse($messages);
//        $sms = "sms";
//
//        // ��� �� ���� ��������� ������� $messages
//        foreach ($messages as $value) {
//            // ���������� ����������� ������ ��� �������� ������������
//            $js .= 'chat.append("<p>' . $value['name'] . '&raquo; ' . $value['text'] . '</p>");'; // �������� �������� (<span>��� &raquo; ����� ���������</span>) � ��� div
//        }
//
//        // ������� ����� ���������� ����������� ���������, ��� �� � ��������� ��� ������ �������� � ����� ���������
//
//        // ���������� ���������� ��� ������������, ��� �� ����� �������� ��� ������ ������� eval()
//        echo $js;
//    }
//
//}

?>