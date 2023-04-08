<?php

function connect_db() {
    try {
        return $pdo = new PDO("mysql:host=localhost;dbname=db_main;", "root", "");
    } catch (PDOException $error) {
        set_flash_message('База недоступна ' . $error);
        redirectTo("page_register");
    }
}

function get_user_by_email($email, $redirect = "page_register") {
    $pdo = connect_db();
    $query = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $query->execute(['email'=>$email]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        set_flash_message("Этот эл. адрес уже занят другим пользователем.");
        redirectTo($redirect);
    } else {
        return true;
    }
}

function add_user($email, $pass) {
    $pdo = connect_db();
    $query = $pdo->prepare("INSERT INTO users (email, pass) VALUES (?, ?);");
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $query->execute([$email, $hash]);
    $id = $pdo->lastInsertId();
    $query = $pdo->prepare("INSERT INTO info (id) VALUES (?);");
    $query->execute([$id]);  
    return $id;
}

function set_flash_message($message, $style = "danger") {
    $_SESSION["message"] = $message;
    $_SESSION["style"] = $style;
}

function display_flash_message() {
     if (isset($_SESSION["message"])): echo <<<HTML
        <div class="alert alert-$_SESSION[style] text-dark" role="alert">
            $_SESSION[message];
        </div>
HTML;
         unset($_SESSION['message']);
         unset($_SESSION['style']);
     endif;
}

function redirectTo($url) {
    header("Location: " . $url . ".php");
    exit;
}

function login($email, $password) {
    if (!isset($_SESSION["user"])) {
        $pdo = connect_db();
        $query = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $query->execute(['email'=>$email]);
        $result=$query->fetch(PDO::FETCH_ASSOC);
        if (empty($result) or (!password_verify($password, $result['pass']))) {
            set_flash_message("Неверный логин или пароль.");
            redirectTo("page_login");
            return false;
        }
        $user = [
             "id" => $result['id'],
             "email" => $result['email'],
             "role" => $result['role']
        ];
        $_SESSION["user"] = $user;
    } 
    redirectTo("users");
    return true;
}

function is_logged_in() {
    if (isset($_SESSION['user'])) {
        return true;
    } 
    return false;
}

function is_not_logged_in() {
    return !is_logged_in();
}

function get_users() {
    $pdo = connect_db();
    $query = $pdo->prepare("SELECT * FROM info");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_auth_user() {
    if(is_logged_in()) {
        return $_SESSION['user'];
    }
    return false;
}

function is_admin($user) {
    if(is_logged_in() and $user['role'] === "admin") {
         return true;      
    }
    return false;
}

function is_equal($user1, $user2) {
    return $user1['id'] === $user2['id'];
}

function check_session() {
    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   
}

function edit_info($id, $username, $job_title, $phone, $email, $address) {
    $pdo = connect_db();
    $query = $pdo->prepare("UPDATE info SET username=:username, job_title=:job_title, phone=:phone, email=:email, address=:address WHERE id=$id;");
    $query->execute(['username'=>$username, 'job_title'=>$job_title, 'phone'=>$phone, 'email'=>$email, 'address'=>$address]);    
}

function set_status($id, $status) {
    $pdo = connect_db();
    $query = $pdo->prepare("UPDATE info SET status=:status WHERE id=$id;");
    $query->execute(['status'=>$status]);    
}

function add_social_links($id, $vk, $telegram, $instagram) {
    $pdo = connect_db();
    $query = $pdo->prepare("UPDATE info SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE id=$id;");
    $query->execute(['vk'=>$vk, 'telegram'=>$telegram, 'instagram'=>$instagram]);    
}

function upload_new_avatar($id, $file) {
    $uploaddir = '/task2/img/demo/avatars/';
    $pdo = connect_db();
    // Upload new file avatar
    $name = upload_file($file);
    $query = $pdo->prepare("UPDATE info SET image=:image WHERE id=$id;");
    $query->execute(['image'=>$name]);      
}

function delete_old_avatar($id, $file) {
    $uploaddir = '/task2/img/demo/avatars/';
    $pdo = connect_db();
    // Delete old file avatar
    $query = $pdo->prepare("SELECT image FROM info WHERE id = ?");
    $query->execute([$id]);
    $oldFile = $query->fetch(PDO::FETCH_ASSOC);
    if(!empty($oldFile) and (file_exists($uploaddir . $file["image"]))) {
        unlink($uploaddir . $file["image"]);
    }
}

function is_image($file){
    if(($file['name'] == '') || ($file['size'] == 0))
		return false;
	$getMime = explode('.', $file['name']);
	$mime = strtolower(end($getMime));
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	if(!in_array($mime, $types)) 
        return false;
	return true;
  }
  
function upload_file($file){	
    $uploaddir = '/task2/img/demo/avatars/';
	$name = uniqid() . $file['name'];
	move_uploaded_file( $file['tmp_name'],  $_SERVER["DOCUMENT_ROOT"] . $uploaddir . $name);
	return $name;
  }

function is_author($current_user_id) {
    $logged_user_id = get_auth_user();
    $tmp = $logged_user_id['id'];
    if($logged_user_id['id'] == $current_user_id) 
        return true;
}

function get_user_by_id($id) {
    $pdo = connect_db();
    $query = $pdo->prepare("SELECT * FROM info WHERE id=$id");
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function set_current_id($id) {
    $_SESSION['user'] += ['id_edit_user'=>$id];
}

function get_current_id() {
    return $_SESSION['user']['id_edit_user'];
}