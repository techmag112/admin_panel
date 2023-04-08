<?php

require "functions.php";

check_session();

$new_email = $_POST["email"];
$new_pass = $_POST["password"];

if(($_SESSION['user']['email'] !== $new_email) and get_user_by_email($new_email, "security")) {
    if(($new_pass === "**********") or (password_verify($new_pass, $_SESSION['user']['pass']))) {
        $new_pass = null;
    } else {
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    }
    edit_credentials(get_current_id(), $new_email, $new_pass);
    set_flash_message("Профиль успешно обновлен.", "success");
    redirectTo("page_profile"); 
} else {
    redirectTo("security");
}