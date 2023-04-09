<?php

require "functions.php";

check_session();

['email'=>$email, 'password'=>$pass, 'username'=>$username, 'job_title'=>$job_title, 'phone'=>$phone, 
'address'=>$address, 'status'=>$status, 'vk'=>$vk, 'telegram'=>$telegram, 'instagram'=>$instagram] = $_POST;

if (get_user_by_email($email, "create_user")) {
    set_current_id(add_user($email, $pass));
    edit_info(get_current_id(), $username, $job_title, $phone, $email, $address);
    set_status(get_current_id(), $status);
    if(is_image($_FILES['image'])) {
        delete_old_avatar(get_current_id());
        upload_new_avatar(get_current_id(), $_FILES['image']);
    }
    add_social_links(get_current_id(), $vk, $telegram, $instagram);
    set_flash_message("Пользователь успешно добавлен.", "success");
    redirectTo("users");
}

 