<?php
session_start();

// If user is already logged in, redirect them away from login page
if (isset($_SESSION['user_id'])) {
    require_once '../Model/user.php';
    $user = new User();
    $user_data = $user->getUserById($_SESSION['user_id']);
    
    if ($user_data) {
        $role = trim($user->getUserRole($user_data['email']));
        if (strcasecmp($role, 'Admin') === 0) {
            header("Location: adminDashboard.php");
        } else {
            header("Location: userInfo.php");
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Login</title>
    <link rel="stylesheet" href="../Style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="manga-panel"></div>

    <div class="speech-bubble bubble1">Welcome to Manga World!</div>
    <div class="speech-bubble bubble2">Login to read!</div>
    <div class="speech-bubble bubble3">Konnichiwa!</div>

    <div class="speed-line line1"></div>
    <div class="speed-line line2"></div>

    <div class="chibi chibi1"></div>
    <div class="chibi chibi2"></div>

    <form action="../Controllers/auth.php" method="POST" class="login-container">
        <h1>LOGIN</h1>

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>

        <button type="submit" name="login">LOGIN</button>
        <button type="button" style="margin-top: 15px;" onclick="window.location.href='/Manga-System/'">CANCEL</button>

        <div class="links">
            <a href="../View/signUp.php">Create an Account</a>
        </div>
    </form>
</body>

</html>