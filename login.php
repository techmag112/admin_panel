<?php

require "functions.php";

check_session();

$email = $_POST["email"];
$pass = $_POST["password"];

login($email, $pass);



