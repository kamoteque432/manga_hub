<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../Model/user.php';
$user = new User();

$user_login = $user->getUserById($_SESSION['user_id']);

// If user data not found, clear session and redirect
if (!$user_login) {
    unset($_SESSION['user_id']);
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | MangaVerse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/userInfo.css">
</head>

<body>
    <?php include "../Includes/navbar.php" ?>

    <!-- Floating decorative elements -->
    <div class="floating floating-1">✧</div>
    <div class="floating floating-2">♡</div>

    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <img src="https://i.pinimg.com/originals/c6/3f/aa/c63faaaf70c45e93e0a70d025ebc5e12.png" alt="Profile Avatar" class="profile-avatar">
            <div class="profile-info">
                <h1 class="profile-name"><?php echo $user_login['email']; ?></h1>
                <p class="profile-username">@<?php echo $user_login['username']; ?></p>
                
                <!-- <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number">1,284</div>
                        <div class="stat-label">Favorites</div>
                    </div>
                </div> -->
            </div>
            <!-- <button class="edit-profile-btn">
                <i class="fas fa-user-edit"></i> 
            </button> -->
        </div>

        <!-- Profile Tabs -->
        <!-- <div class="profile-tabs">
            <button class="tab-btn active">
                <i class="fas fa-heart"></i> Favorites
            </button>
        </div> -->

        <!-- Recently Read Section
        <div class="manga-grid">
            Manga Card 1 
            <div class="manga-card">
                <img src="https://meo.comick.pictures/5pMrqZ-m.jpg" class="manga-cover" alt="The Thousand Faces Actor">
                <div class="manga-info">
                    <h3 class="manga-title">The Thousand Faces Actor</h3>
                    <div class="manga-meta">
                        <span>Ch. 45</span>
                        <span>2h ago</span>
                    </div>
                </div>
            </div>

             Manga Card 2 
            <div class="manga-card">
                <img src="https://i.imgur.com/5QX2Q1r.jpg" class="manga-cover" alt="Attack on Titan">
                <div class="manga-info">
                    <h3 class="manga-title">Attack on Titan</h3>
                    <div class="manga-meta">
                        <span>Ch. 139</span>
                        <span>1d ago</span>
                    </div>
                </div>
            </div>

             Manga Card 3 
            <div class="manga-card">
                <img src="https://i.imgur.com/8XJQ2Zr.jpg" class="manga-cover" alt="Demon Slayer">
                <div class="manga-info">
                    <h3 class="manga-title">Demon Slayer</h3>
                    <div class="manga-meta">
                        <span>Ch. 205</span>
                        <span>3d ago</span>
                    </div>
                </div>
            </div>

           Manga Card 4 
            <div class="manga-card">
                <img src="https://i.imgur.com/3QX2Q1r.jpg" class="manga-cover" alt="One Piece">
                <div class="manga-info">
                    <h3 class="manga-title">One Piece</h3>
                    <div class="manga-meta">
                        <span>Ch. 1045</span>
                        <span>5d ago</span>
                    </div>
                </div>
            </div>

            Manga Card 5 
            <div class="manga-card">
                <img src="https://i.imgur.com/7QX2Q1r.jpg" class="manga-cover" alt="Jujutsu Kaisen">
                <div class="manga-info">
                    <h3 class="manga-title">Jujutsu Kaisen</h3>
                    <div class="manga-meta">
                        <span>Ch. 187</span>
                        <span>1w ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <?php include "../Includes/footer.php" ?>
</body>

</html>