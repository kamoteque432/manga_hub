<?php

include "../Model/comic.php";
$comic = new Comic();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Catalog | MangaVerse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/mangasPage.css">
</head>

<body>
    <?php include '../Includes/navbar.php' ?>

    
    <!-- Floating decorative elements -->
    <div class="floating floating-1">✧</div>
    <div class="floating floating-2">♡</div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title" style="margin-right: 40px;">
                <i class="fas fa-book-open"></i> Manga Catalog
            </h1>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search manga...">
            </div>
        </div>

        <!-- Filter and Sort Controls -->
        <div class="controls">
            <div class="filter-group">
                <label class="filter-label">Sort By</label>
                <select class="filter-select">
                    <option>Popularity</option>
                    <option>Newest</option>
                    <option>Rating</option>
                    <option>Title (A-Z)</option>
                    <option>Title (Z-A)</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select">
                    <option>All Status</option>
                    <option>Ongoing</option>
                    <option>Completed</option>
                    <option>Hiatus</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Genre</label>
                <select class="filter-select">
                    <option>All Genres</option>
                    <option>Action</option>
                    <option>Adventure</option>
                    <option>Comedy</option>
                    <option>Drama</option>
                    <option>Fantasy</option>
                    <option>Horror</option>
                    <option>Romance</option>
                    <option>Sci-Fi</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Type</label>
                <select class="filter-select">
                    <option>All Types</option>
                    <option>Manga</option>
                    <option>Manhwa</option>
                    <option>Manhua</option>
                    <option>Webtoon</option>
                </select>
            </div>
        </div>

        <!-- Manga Grid -->
        <div class="manga-grid">
            <!-- Manga Card 1 -->
            <?php
            $comics = $comic->getAllComics();

            if ($comics) {
                foreach ($comics as $item) { ?>
                    <a href="../View/mangaInfo.php?id=<?php echo $item["comic_id"] ?>" class="manga-card">
                        <img src="<?php echo $item["cover"] ?>" class="manga-cover" alt="The Thousand Faces Actor">
                        <div class="manga-info">
                            <h3 class="manga-title"><?php echo $item["title"] ?></h3>
                            <div class="manga-meta">
                                <span><?php echo $item["chapters"] ?> Chapters</span>
                                <span><?php echo $item["published_year"] ?></span>
                            </div>
                        </div>
                    </a>
            <?php }
            }
            ?>

        </div>

        <!-- Pagination -->
        <div class="pagination">
            <div class="page-item">
                <a href="#" class="page-link disabled">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link active">1</a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link">2</a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link">3</a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link">4</a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link">5</a>
            </div>
            <div class="page-item">
                <a href="#" class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</body>

</html>