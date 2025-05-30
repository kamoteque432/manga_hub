<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    header("location: ../index.php");
    exit();
}

require_once __DIR__ . '/../Model/user.php';

$user_login = $user->getUserById($_SESSION['user_id']);
