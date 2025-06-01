<?php
include "../Model/user.php";
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['signUp'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($username && $email && $password && $confirmPassword) {
            if ($user->isEmailTaken($email)) {
                header("Location: ../View/signUp.php?error=emailUsed");
                exit();
            }

            if ($password !== $confirmPassword) {
                header("Location: ../View/signUp.php?error=passwordMismatch");
                exit();
            }


            $result_add = $user->addUser($username, $email, $password);
            if ($result_add) {
                header("location: ../View/login.php");
                exit();
            } else {
                echo "<script>alert('Failed to add user');</script>";
            }
        } else {
            header("Location: ../View/signUp.php?error=fillTheBlank");
            exit();
        }
    } else if (isset($_POST['edit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $role = $_POST['role'];
        $user_id = $_POST['user_id'];

        $existingUser = $user->getUserById($user_id);

        if (!$existingUser) {
            header("Location: ../View/adminEditUser.php?edit=$user_id&error=userNotFound");
            exit();
        }

        if ($user->isEmailTaken($email) && $email !== $existingUser['email']) {
            header("Location: ../View/adminEditUser.php?edit=$user_id&error=emailUsed");
            exit();
        }

        if ($password !== $confirmPassword) {
            header("Location: ../View/adminEditUser.php?edit=$user_id&error=passwordMismatch");
            exit();
        }


        $result_add = $user->editUser($user_id, $username, $email, $password, $role);

        if ($result_add) {
            header("location: ../View/adminListUsers.php");
            exit();
        } else {
            echo "<script>alert('Failed to edit user');</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['delete'])) {
        $get_id = $_GET['delete'];

        $result = $user->deleteUser($get_id);

        if ($result) {
            header("Location: ../View/AdminListUsers.php");
            exit();
        }
    }
}