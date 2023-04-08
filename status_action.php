<?php 

require "functions.php";

check_session();

$new_status = $_POST["status"];

set_status(get_current_id(), $new_status);
set_flash_message("Профиль успешно обновлен.", "success");
redirectTo("page_profile"); 
