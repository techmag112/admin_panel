<?php

require "functions.php";

check_session();

['username'=>$username, 'job_title'=>$job_title, 'phone'=>$phone, 'address'=>$address] = $_POST;
$email = $_SESSION['user']['email'];

edit_info(get_current_id(), $username, $job_title, $phone, $email, $address);

set_flash_message("Профиль успешно обновлен.", "success");

redirectTo("page_profile");