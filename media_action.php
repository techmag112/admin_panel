<?php

require "functions.php";

check_session();

if(is_image($_FILES['image'])) {
    delete_old_avatar(get_current_id());
    upload_new_avatar(get_current_id(), $_FILES['image']);
}
set_flash_message("Профиль успешно обновлен.", "success");
redirectTo("page_profile"); 
