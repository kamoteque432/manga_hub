<?php
session_start();
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

include '../Model/favorite.php';
$favorite = new Favorite();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorite Manga | MangaVerse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/favorites.css">
</head>

<body>
    <?php include "../Includes/navbar.php" ?>

    <div class="container">
        <div class="header">
            <h1 class="page-title">
                <i class="fas fa-heart"></i>
                My Favorite Manga
            </h1>
            <div class="sort-filter">
                <button class="sort-btn">
                    <i class="fas fa-sort"></i>
                    Sort By
                </button>
                <button class="filter-btn">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>

        <div class="favorites-grid">
            <?php
            $favorites = $favorite->getUserFavorites($user_id);
            if ($favorites && count($favorites) > 0) {
                foreach ($favorites as $item) { ?>
                    <div class="manga-card">
                        <div class="favorite-badge">
                            <i class="fas fa-heart"></i>
                        </div>
                        <img src="<?php echo $item['cover'] ?>" class="manga-cover" alt="<?php echo $item['title']; ?>">
                        <div class="manga-info">
                            <h3 class="manga-title"><?php echo $item['title']; ?></h3>
                            <div class="manga-meta">
                                <span><?php echo $item['origination']; ?></span>
                            </div>
                            <p class="manga-description">
                                <?php echo $item['description']; ?>
                            </p>
                            <div class="card-footer">
                                <span><?php echo $item['chapters']; ?> Chapters</span>
                                <form action="../Controllers/action_favorite.php" method="POST">
                                    <input type="hidden" name="comic_id" value="<?php echo $item['comic_id']; ?>">
                                    <input type="hidden" name="from_page" value="favorites">
                                    <button class="action-btn" type="submit" name="unfavorite" title="Remove from favorites">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <!-- Show this only if no favorites -->
                <div class="empty-state">
                    <i class="fas fa-heart-broken"></i>
                    <h3>No Favorites Yet</h3>
                    <p>You haven't added any manga to your favorites list. Start exploring and add some!</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include "../Includes/footer.php" ?>
</body>

</html>