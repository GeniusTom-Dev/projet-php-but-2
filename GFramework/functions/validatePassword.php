<?php
function validatePassword($password){
    if (strlen($password) < 6) {
        return false;
    }

    if (!preg_match('/[a-zA-Z]/', $password)) {
        return false;
    }

    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    return true;
}

?>