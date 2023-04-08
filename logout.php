<?php

require "functions.php";

check_session();

unset($_SESSION['user']);
session_destroy();

redirectTo("page_login");