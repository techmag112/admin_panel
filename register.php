<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$email = $_POST["email"];
$pass = $_POST["password"];

require "functions.php";

if (get_user_by_email($email)) {
    add_user($email, $pass);
    set_flash_message("Пользователь успешно добавлен.", "success");
    redirectTo("page_login");
}
