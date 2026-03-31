<?php

function mysql_old_password_check($password, $user_pass) {
    $pass_crypt = "*".strtoupper(sha1(hex2bin(sha1($password))));

    return ($pass_crypt == $user_pass);
}