<?php


function matchPasswords($password, $password_repeated){
    $result = true;
    if($password === $password_repeated){
        $result = true;
        echo ("match");
    }else{
        $result = false;
    }
    return $result;
}
matchPasswords("hey","hey");
?>