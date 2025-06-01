<?php
session_start();
include '../Model/user.php';
$user = new User();

// Redirect to login if not authenticated (for all non-POST requests)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}

// Handle login POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->login($email, $password)) {
            $_SESSION['user_id'] = $user->getUserId($email);
            $role = trim($user->getUserRole($email));

            if (strcasecmp($role, 'Admin') === 0) {
                header("Location: ../View/adminDashboard.php");
            } elseif (strcasecmp($role, 'User') === 0) {
                header("Location: ../View/userInfo.php");
            } else {
                // Invalid role - clear session and redirect to login
                unset($_SESSION['user_id']);
                header("Location: ../View/login.php?error=invalid_role");
            }
            exit();
        } else {
            // Login failed
            header("Location: ../View/login.php?error=invalid_credentials");
            exit();
        }
    }
}

// If user reaches this point and is logged in, redirect to appropriate dashboard
if (isset($_SESSION['user_id'])) {
    $email = $user->getUserEmailById($_SESSION['user_id']);
    if ($email) {
        $role = trim($user->getUserRole($email));
        
        if (strcasecmp($role, 'Admin') === 0) {
            header("Location: ../View/adminDashboard.php");
        } elseif (strcasecmp($role, 'User') === 0) {
            header("Location: ../View/userInfo.php");
        } else {
            // Invalid role - clear session and redirect to login
            unset($_SESSION['user_id']);
            header("Location: ../View/login.php?error=invalid_role");
        }
    } else {
        // User ID not found - clear session and redirect to login
        unset($_SESSION['user_id']);
        header("Location: ../View/login.php?error=user_not_found");
    }
    exit();
}

// If nothing else applies, show login page
header("Location: ../View/login.php");
exit();