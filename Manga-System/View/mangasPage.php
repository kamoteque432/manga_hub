<?php

include "../Model/comic.php";
$comic = new Comic();

// Pagination logic
$limit = 10; // comics per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$totalComics = $comic->getTotalComicsCount();
$totalPages = ceil($totalComics / $limit);
$offset = ($page - 1) * $limit;

$comics = $comic->getComicsByPage($limit, $offset);
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
                <input type="text" id="searchInput" placeholder="Search manga...">
            </div>
        </div>

        <!-- Filter and Sort Controls -->
        <div class="controls">
            <div class="filter-group">
                <label class="filter-label">Sort By</label>
                <select id="sortSelect" class="filter-select">
                    <option value="default">Default</option>
                    <option value="title-asc">Title (A-Z)</option>
                    <option value="title-desc">Title (Z-A)</option>
                    <option value="chapters-desc">Chapters (High-Low)</option>
                    <option value="chapters-asc">Chapters (Low-High)</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select id="statusSelect" class="filter-select">
                    <option>All Status</option>
                    <option>Ongoing</option>
                    <option>Completed</option>
                    <option>Hiatus</option>
                    <option>Cancelled</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Genre</label>
                <select id="genreSelect" class="filter-select">
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
                <select id="typeSelect" class="filter-select">
                    <option>All Types</option>
                    <option>Manga</option>
                    <option>Manhwa</option>
                    <option>Manhua</option>
                    <option>Webtoon</option>
                </select>
            </div>
        </div>

        <!-- Manga Grid -->
        <div class="manga-grid" id="mangaGrid">
            <?php if ($comics): ?>
                <?php foreach ($comics as $item): ?>
                    <a href="../View/mangaInfo.php?id=<?php echo $item["comic_id"] ?>"
                        class="manga-card manga-item"
                        data-title="<?php echo strtolower($item["title"]) ?>"
                        data-status="<?php echo strtolower($item["status"]) ?>"
                        data-genre="<?php echo strtolower($item["genres"]) ?>"
                        data-type="<?php echo strtolower($item["origination"]) ?>"
                        data-chapters="<?php echo $item["chapters"] ?>">
                        <img src="<?php echo $item["cover"] ?>" class="manga-cover" alt="<?php echo $item["title"] ?>">
                        <div class="manga-info">
                            <h3 class="manga-title"><?php echo $item["title"] ?></h3>
                            <div class="manga-meta">
                                <span><?php echo $item["chapters"] ?> Chapters</span>
                                <span><?php echo $item["published_year"] ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No manga found.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <div class="page-item"><a href="?page=<?php echo $page - 1 ?>" class="page-link"><i class="fas fa-chevron-left"></i></a></div>
            <?php else: ?>
                <div class="page-item"><a href="#" class="page-link disabled"><i class="fas fa-chevron-left"></i></a></div>
            <?php endif; ?>

            <?php
            // Show page numbers - simple version
            for ($i = 1; $i <= $totalPages; $i++):
                $active = ($i === $page) ? 'active' : '';
            ?>
                <div class="page-item"><a href="?page=<?php echo $i ?>" class="page-link <?php echo $active ?>"><?php echo $i ?></a></div>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <div class="page-item"><a href="?page=<?php echo $page + 1 ?>" class="page-link"><i class="fas fa-chevron-right"></i></a></div>
            <?php else: ?>
                <div class="page-item"><a href="#" class="page-link disabled"><i class="fas fa-chevron-right"></i></a></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Script -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const statusSelect = document.getElementById('statusSelect');
        const genreSelect = document.getElementById('genreSelect');
        const typeSelect = document.getElementById('typeSelect');
        const sortSelect = document.getElementById('sortSelect');
        const mangaGrid = document.getElementById('mangaGrid');
        let mangaItems = Array.from(document.querySelectorAll('.manga-item'));

        function filterManga() {
            const searchQuery = searchInput.value.toLowerCase();
            const selectedStatus = statusSelect.value.toLowerCase();
            const selectedGenre = genreSelect.value.toLowerCase();
            const selectedType = typeSelect.value.toLowerCase();

            mangaItems.forEach(item => {
                const title = item.dataset.title;
                const status = item.dataset.status;
                const genreList = item.dataset.genre.split(',').map(g => g.trim().toLowerCase()); // split by comma
                const type = item.dataset.type;

                const matchSearch = title.includes(searchQuery);
                const matchStatus = selectedStatus === "all status" || status === selectedStatus;
                const matchGenre = selectedGenre === "all genres" || genreList.includes(selectedGenre); // fixed here
                const matchType = selectedType === "all types" || type === selectedType;

                if (matchSearch && matchStatus && matchGenre && matchType) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function sortManga() {
            const sortBy = sortSelect.value;

            let sorted = [...mangaItems].filter(item => item.style.display !== 'none');

            sorted.sort((a, b) => {
                if (sortBy === "title-asc") {
                    return a.dataset.title.localeCompare(b.dataset.title);
                } else if (sortBy === "title-desc") {
                    return b.dataset.title.localeCompare(a.dataset.title);
                } else if (sortBy === "chapters-desc") {
                    return parseInt(b.dataset.chapters) - parseInt(a.dataset.chapters);
                } else if (sortBy === "chapters-asc") {
                    return parseInt(a.dataset.chapters) - parseInt(b.dataset.chapters);
                }
                return 0;
            });

            // Clear and re-append sorted items
            sorted.forEach(item => mangaGrid.appendChild(item));
        }

        // Add event listeners
        searchInput.addEventListener('input', () => {
            filterManga();
            sortManga();
        });
        statusSelect.addEventListener('change', () => {
            filterManga();
            sortManga();
        });
        genreSelect.addEventListener('change', () => {
            filterManga();
            sortManga();
        });
        typeSelect.addEventListener('change', () => {
            filterManga();
            sortManga();
        });
        sortSelect.addEventListener('change', sortManga);
    </script>
</body>

</html>