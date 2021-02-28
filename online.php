<?php

require_once "blocks/bd.php";
require_once "blocks/functions.php";
$res = get_users_online();
$otvet = "";
while ($row = $res->fetch_assoc()) {
    $otvet .= "<li>".$row['name']." ".$row['family']."</li>";
}
echo $otvet;
?>