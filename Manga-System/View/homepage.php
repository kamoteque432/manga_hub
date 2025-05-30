<?php

include "Model/comic.php";
$comic = new Comic();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaVerse - Your Ultimate Manga Destination</title>
    <link rel="stylesheet" href="../Style/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "Includes/navbar.php" ?>

    <div class="speed-lines"></div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bubbles">
            <div class="bubble" style="width: 40px; height: 40px; left: 10%; animation-duration: 12s;"></div>
            <div class="bubble" style="width: 25px; height: 25px; left: 20%; animation-duration: 15s; animation-delay: 2s;"></div>
            <div class="bubble" style="width: 50px; height: 50px; left: 35%; animation-duration: 18s; animation-delay: 1s;"></div>
            <div class="bubble" style="width: 30px; height: 30px; left: 50%; animation-duration: 14s; animation-delay: 3s;"></div>
            <div class="bubble" style="width: 45px; height: 45px; left: 65%; animation-duration: 16s;"></div>
            <div class="bubble" style="width: 20px; height: 20px; left: 80%; animation-duration: 13s; animation-delay: 2s;"></div>
        </div>

        <div class="container hero-content">
            <div class="hero-text">
                <h1>Discover Your Next Manga Adventure</h1>
                <p>Explore thousands of manga titles from all genres. Read the latest chapters, follow your favorite series, and join our growing community of manga enthusiasts.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-fire"></i> Trending Now
                    </a>
                    <a href="./View/mangasPage.php" class="btn btn-secondary">
                        <i class="fas fa-compass"></i> Explore
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <img src="https://www.record.com.mx/sites/default/files/inline-images/TRALALERO%202.jpg" alt="Manga Characters" width="400">
            </div>
        </div>
    </section>

    <!-- Popular Manga Section -->
    <section class="container">
        <div class="section-title">
            <h2>Popular Manga</h2>
        </div>

        <div class="manga-grid">
            <?php
            $comics = $comic->getAllComics();

            if ($comics) {
                foreach ($comics as $item) { ?>
                    <a href="View/mangaInfo.php?id=<?php echo $item["comic_id"] ?>" class="manga-card">
                        <div class="manga-cover">
                            <img src="<?php echo $item["cover"] ?>">
                        </div>
                        <div class="manga-info">
                            <h3 class="manga-title"><?php echo $item["title"] ?></h3>
                            <div class="manga-meta">
                                <span>Chapter <?php echo $item["chapters"] ?></span>
                                <!-- <span class="manga-rating"><i class="fas fa-star"></i> 4.9</span> -->
                            </div>
                        </div>
                    </a>
            <?php }
            }
            ?>
        </div>
    </section>

    <!-- New Releases Section
    <section class="container">
        <div class="section-title">
            <h2>New Releases</h2>
        </div>

        <div class="manga-grid">
            <div class="manga-card">
                <span class="manga-badge">Today</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/aQX2Q1r.jpg" alt="Spy x Family">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Spy x Family</h3>
                    <div class="manga-meta">
                        <span>Chapter 62</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <span class="manga-badge">Today</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/bQX2Q1r.jpg" alt="Blue Lock">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Blue Lock</h3>
                    <div class="manga-meta">
                        <span>Chapter 195</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.7</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <span class="manga-badge">New</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/cQX2Q1r.jpg" alt="Kaiju No. 8">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Kaiju No. 8</h3>
                    <div class="manga-meta">
                        <span>Chapter 78</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.6</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <span class="manga-badge">Updated</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/dQX2Q1r.jpg" alt="The Apothecary Diaries">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">The Apothecary Diaries</h3>
                    <div class="manga-meta">
                        <span>Chapter 65</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.8</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="section-title">
            <h2>Hot This Week</h2>
        </div>

        <div class="manga-grid">
            <div class="manga-card">
                <span class="manga-badge">Trending</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/eQX2Q1r.jpg" alt="Solo Leveling">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Solo Leveling</h3>
                    <div class="manga-meta">
                        <span>Chapter 179</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <span class="manga-badge">Popular</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/fQX2Q1r.jpg" alt="The Beginning After The End">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">The Beginning After The End</h3>
                    <div class="manga-meta">
                        <span>Chapter 142</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.8</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <div class="manga-cover">
                    <img src="https://i.imgur.com/gQX2Q1r.jpg" alt="Tower of God">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Tower of God</h3>
                    <div class="manga-meta">
                        <span>Chapter 523</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.7</span>
                    </div>
                </div>
            </div>

            <div class="manga-card">
                <span class="manga-badge">Rising</span>
                <div class="manga-cover">
                    <img src="https://i.imgur.com/hQX2Q1r.jpg" alt="Omniscient Reader">
                </div>
                <div class="manga-info">
                    <h3 class="manga-title">Omniscient Reader</h3>
                    <div class="manga-meta">
                        <span>Chapter 112</span>
                        <span class="manga-rating"><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <?php include "Includes/footer.php" ?>
</body>

</html>