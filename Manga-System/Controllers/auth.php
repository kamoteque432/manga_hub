<?php
session_start();
include '../Model/user.php';
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // if ($user->login($email, $password)) {
        //     $_SESSION['user_id'] = $user->getUserId($email);
        //     $role = $user->getUserRole($email);

        // if (strcasecmp($role, 'Admin') === 0) {
        //     header("Location: ../View/adminDashboard.php");
        // } elseif (strcasecmp($role, 'User') === 0) {
        //     header("Location: ../View/index.php");
        // } else {
        //     header("Location: ../View/login.php?error=Unknown user role");
        // }
        // exit();
        //     }
        // }

        if ($user->login($email, $password)) {
        $_SESSION['user_id'] = $user->getUserId($email);
        $role = trim($user->getUserRole($email)); // Trim any whitespace

        if (strcasecmp($role, 'Admin') === 0) {
            header("Location: ../View/adminDashboard.php");
        } elseif (strcasecmp($role, 'User') === 0) {
            header("Location: ../View/index.php");
        } else {
            header("Location:../View/login.php?error=Unknown user role");
        }
        exit();
    }

    }
}