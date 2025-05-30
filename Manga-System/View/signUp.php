<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Signup</title>
    <link rel="stylesheet" href="../Style/signUp.css">
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

    <form action="../Controllers/action_user.php" method="POST" class="login-container">
        <h1>MANGA SIGN UP</h1>

        <div class="input-group">
            <i class="fas fa-user-ninja"></i>
            <input type="text" id="username" name="username" placeholder=" " required>
            <label for="username">Username</label>
        </div>

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" placeholder=" " required >
            <label for="email">Email</label>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder=" " required>
            <label for="confirmPassword">Confirm Password</label>
        </div>

        <button type="submit" name="signUp">SIGN UP</button>
        <button type="cencel" style="margin-top: 15px;">CANCEL</button>

        <div class="links">
            <span>Already a manga warrior?</span>
            <a href="login.php">Log in to your dojo</a>
        </div>
    </form>
</body>

</html>