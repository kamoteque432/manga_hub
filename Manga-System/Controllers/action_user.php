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
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $oldPassword = $_POST['oldPassword'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $user_id = $_POST['user_id'];

        $existingUser = $user->getUserById($user_id);

        if (!$existingUser) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=userNotFound");
            exit();
        }

        $storedHashedPassword = $existingUser['password'];

        if (!password_verify($oldPassword, $storedHashedPassword)) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=invalidOldPassword");
            exit();
        }

        if ($user->isEmailTaken($email) && $email !== $existingUser['email']) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=emailUsed");
            exit();
        }

        if ($password !== $confirmPassword) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=passwordMismatch");
            exit();
        }


        $result_add = $user->editUser($user_id, $firstName, $lastName, $email, $password);

        if ($result_add) {
            header("location: ../View/AdminListOfUsers.php");
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
