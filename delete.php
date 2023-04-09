<?php

require "functions.php";

check_session();

if(is_not_logged_in()) {
    redirectTo("page_login");
}

if(isset($_GET['id']))
        set_current_id($_GET['id']);

if((is_admin(get_auth_user())) or (is_author(get_current_id()))) {
        if (delete_user(get_current_id())) {
            redirectTo("logout");    
        } else {
            redirectTo("users");
        }
} else {
        set_flash_message("Можно редактировать только свой профиль!");
        redirectTo("users");
}

