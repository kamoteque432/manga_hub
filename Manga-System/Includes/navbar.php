
<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 3) Font Awesome -->
    <link
    rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- 4) Your navbar CSS -->
    <link rel="stylesheet" href="/Manga-System/Style/navbar.css">
</head>
<body>
<nav class="navbar">
<div class="nav-container">
    <a href="/Manga-System/Controllers/logout.php" class="logo">
    <i class="fas fa-book-open"></i>
    <span>MangaVerse</span>
    </a>
    <ul class="nav-links">
    <li><a href="/Manga-System/">Home</a></li>
    <li><a href="/Manga-System/View/mangasPage.php">Mangas</a></li>
    
    <?php if ($user_id): ?>
        <li><a href="/Manga-System/Controllers/logout.php">Log Out</a></li>
    <?php else: ?>
        
    <?php endif; ?>
    </ul>

    <div class="nav-actions">
    <div class="nav-search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search manga...">
    </div>

    <?php if ($user_id): ?>
        <div class="user-actions">
        <a href="/Manga-System/View/favorites.php">
            <i class="fas fa-bookmark"></i>
        </a>
        <a href="/Manga-System/View/userInfo.php">
            <i class="fas fa-user"></i>
        </a>
        </div>
    <?php endif; ?>
    </div>
</div>
</nav>
</body>
</html>
