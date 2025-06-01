<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is logged in but tries to access login page, redirect to appropriate page
if (isset($_SESSION["user_id"])) {
    require_once __DIR__ . '/../Model/user.php';
    $user = new User();
    $user_data = $user->getUserById($_SESSION['user_id']);
    
    if ($user_data) {
        $role = trim($user->getUserRole($user_data['email']));
        if (strcasecmp($role, 'Admin') === 0) {
            header("Location: ../View/adminDashboard.php");
        } else {
            header("Location: ../View/userInfo.php");
        }
        exit();
    } else {
        unset($_SESSION['user_id']);
    }
}