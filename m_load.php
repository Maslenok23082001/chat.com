<?php

require_once "blocks/bd.php";
require_once "blocks/functions.php";

$res = get_messages();
//$name_user = $_POST['name_user'];
$otvet = "";

while ($row = $res->fetch_assoc()) {
    $otvet .= "<p>".$row['name'].' >>> '.$row['text']."</p>";
}
echo $otvet;
?>