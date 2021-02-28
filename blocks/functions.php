<?php
 function get_user ($login) {
     global $bd;
     $result = $bd->query("SELECT * FROM `users` WHERE `login` = '".$login."'");
     return $result;
 }

function get_userid ($id) {
    global $bd;
    $result = $bd->query("SELECT * FROM `users` WHERE `id` = '".$id."'");
    return $result;
}

function get_ls ($room_id) {
    global $bd;
    $result = $bd->query("SELECT * FROM `messages` WHERE `room_id` = '".$room_id."'");
    return $result;
}





function get_user_pass_log ($login, $pass) {
    global $bd;
    $result = $bd->query("SELECT * FROM `users` WHERE `login` = '".$login."' AND `password` = '".$pass."'");
    return $result;
}
function set_user ($login_reg, $password_reg, $name_reg, $family_reg) {
    global $bd;
    $result = $bd->query("INSERT INTO `users` (`login`, `password`, `name`, `family`) VAlUES('".$login_reg."','".$password_reg."', '".$name_reg."', '".$family_reg."')");
    return $result;
}

function offline_user($id) {
    global $bd;
    $result = $bd->query("UPDATE `users` SET  `line` =  'offline' WHERE `id` = ".$id."");
    return $result;
}

function add_chs($id, $id2) {
    global $bd;
    $result = $bd->query("UPDATE `rooms` SET  `chs` =  'true' WHERE (`user1` = ".$id." AND `user2` = ".$id2.") OR (`user1` = ".$id2." AND `user2` = ".$id.")");
    return $result;
}


function del_chs($id, $id2) {
    global $bd;
    $result = $bd->query("UPDATE `rooms` SET  `chs` =  '' WHERE (`user1` = ".$id." AND `user2` = ".$id2.") OR (`user1` = ".$id2." AND `user2` = ".$id.")");
    return $result;
}






function get_users_online() {
    global $bd;
    $result = $bd->query("SELECT * FROM `users` WHERE `line` = 'online'");
    return $result;
}


function get_users() {
    global $bd;
    $result = $bd->query("SELECT * FROM `users`");
    return $result;
}

function get_messages() {
    global $bd;
    $result = $bd->query("SELECT * FROM `messages` WHERE `room_id`=0");
    return $result;
}





function get_room($user1, $user2) {
    global $bd;
    $result = $bd->query("SELECT * FROM `rooms` WHERE `user1`='".$user1."' AND `user2`='".$user2."'");
    return $result;
}



function set_room($user1, $user2) {
    global $bd;
    $result = $bd->query("INSERT INTO `rooms` (`id`, `user1`, `user2`) VALUES(NULL, '".$user1."', '".$user2."')");
    $result2 = $bd->query("SELECT * FROM `rooms` WHERE `user1`='".$user1."' AND `user2`='".$user2."'");
    return $result2;
}


?>