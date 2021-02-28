<?php

require_once "blocks/bd.php";
require_once "blocks/functions.php";
$res = get_ls($_POST['room_id']);

//$name_user = $_POST['name_user'];
$otvet = "";

while ($row = $res->fetch_assoc()) {
    $rt = $row['text'];
    $p = "";
    $asd = 24;
    for ($i=0; $i < strlen($rt) ;$i++) {
        if ($i == $asd) {
            $p .= $rt[$i]."\n";
            $asd += 24;
        }
        else {
            $p .= $rt[$i];
        }
    }
    if ($row['id_us'] == $_POST['id_us']) {
        $otvet .= "<p class='main'>".$p."</p>";
    }
    else {
        $otvet .= "<p class='friend'>".$p."</p>";
    }

}
echo $otvet;
?>