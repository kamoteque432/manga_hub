<?php

include "../Model/comic.php";
$comic = new Comic();

include "../Model/favorite.php";
$favorite = new Favorite();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Thousand Faces Actor | MangaVerse</title>
    <link rel="stylesheet" href="../Style/mangaInfo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "../Includes/navbar.php" ?>

    <div class="manga-panel"></div>
    

    <!-- Floating decorative elements -->
    <div class="floating floating-1">✿</div>
    <div class="floating floating-2">✧</div>
    <div class="floating floating-3">♡</div>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $item = $comic->getComicById($id);
    ?>
        <div class="container">
            <div class="manga-cover">
                <img src="<?php echo $item["cover"] ?>" alt="The Thousand Faces Actor Cover">
                <div class="manga-badge"><?php echo $item["status"] ?></div>
            </div>

            <div class="manga-details">
                <h1 class="title"><?php echo $item["title"] ?></h1>

                <div class="info-container">
                    <div class="info-tag">
                        <i class="fas fa-book"></i> <?php echo $item["origination"] ?>
                    </div>
                    <div class="info-tag">
                        <i class="fas fa-calendar-alt"></i> <?php echo $item["published_year"] ?>
                    </div>
                </div>

                <div class="buttons">
                    
                    <?php
                    
                    $isFavorited = false;
                    if (isset($_SESSION['user_id'])) {
                        $isFavorited = $favorite->isFavorited($_SESSION['user_id'], $id);
                    }
                    ?>
                    <form action="../Controllers/action_favorite.php" method="POST">
                        <input hidden type="text" name="comic_id" value="<?php echo $item['comic_id']; ?>">
                        <button class="read-btn" type="submit">
                            <i class="fas fa-bookmark"></i>
                            <?php echo $isFavorited ? 'Following' : 'Follow'; ?>
                        </button>
                    </form>
                </div>

                <div class="description">
                    <h2 class="section-title">Description</h2>
                    <p><?php echo $item["description"] ?></p>
                </div>

                <div class="more-info">
                    <h2 class="section-title">More Info</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Artists</strong>
                            <p><?php echo $item["artists"] ?></p>
                        </div>
                        <div class="info-item">
                            <strong>Genres</strong>
                            <p><?php echo $item["genres"] ?></p>
                        </div>
                        <div class="info-item">
                            <strong>Themes</strong>
                            <p><?php echo $item["themes"] ?></p>
                        </div>
                        <div class="info-item">
                            <strong>Format</strong>
                            <p><?php echo $item["format"] ?></p>
                        </div>
                        <div class="info-item">
                            <strong>Publishers</strong>
                            <p><?php echo $item["publishers"] ?></p>
                        </div>
                        <div class="info-item">
                            <strong>Chapters</strong>
                            <p><?php echo $item["chapters"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else {
        echo "No ID provided in URL.";
    }
    ?>

    <?php include "../Includes/footer.php" ?>
</body>

</html>