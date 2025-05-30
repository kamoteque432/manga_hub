<?php

include "../Model/comic.php";
$comic = new Comic();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Manga</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/adminAddComic.css">
</head>

<body>
    <div class="floating floating-1">✧</div>
    <div class="floating floating-2">♡</div>

    <?php include "../Includes/adminSidebar.php" ?>

    <div class="main-content">
        <h1><i class="fas fa-plus-circle"></i> Add New Manga</h1>

        <?php
        if (isset($_GET['edit'])) {
            $get_id_edit = $_GET['edit'];
            $row = $comic->getComicById($get_id_edit);
            if ($row) { ?>
                <form action="../Controllers/action_comic.php" method="POST" id="manga-form" class="form-grid">
                    <input type="text" class="form-control" name="comic_id" value="<?php echo $row['comic_id']; ?>" required style="display: none;">
                    <!-- Basic Information -->
                    <div class="form-group">
                        <label for="title">Manga Title *</label>
                        <input type="text" id="title" name="title" required value="<?php echo $row['title'] ?>" placeholder="e.g. The Thousand Faces Actor">
                    </div>

                    <?php $status = $row['status']; ?>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="" disabled <?php if (empty($status)) echo 'selected'; ?>>Select Status</option>
                            <option value="Ongoing" <?php if ($status == 'Ongoing') echo 'selected'; ?>>Ongoing</option>
                            <option value="Completed" <?php if ($status == 'Completed') echo 'selected'; ?>>Completed</option>
                            <option value="Hiatus" <?php if ($status == 'Hiatus') echo 'selected'; ?>>Hiatus</option>
                            <option value="Cancelled" <?php if ($status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </div>

                    <?php $origination = $row['origination'] ?? ''; ?>
                    <div class="form-group">
                        <label for="origination">Origination *</label>
                        <select id="origination" name="origination" required>
                            <option value="" disabled <?php if ($origination == '') echo 'selected'; ?>>Select Type</option>
                            <option value="Manga" <?php if ($origination == 'Manga') echo 'selected'; ?>>Manga</option>
                            <option value="Manhwa" <?php if ($origination == 'Manhwa') echo 'selected'; ?>>Manhwa</option>
                            <option value="Manhua" <?php if ($origination == 'Manhua') echo 'selected'; ?>>Manhua</option>
                            <option value="Webtoon" <?php if ($origination == 'Webtoon') echo 'selected'; ?>>Webtoon</option>
                            <option value="Other" <?php if ($origination == 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="published_year">Published Year *</label>
                        <input type="number" id="published_year" name="published_year" value="<?php echo $row['published_year'] ?>" min="1900" max="2099" required placeholder="e.g. 2025">
                    </div>

                    <div class="form-group">
                        <label for="chapters">Chapters</label>
                        <input type="text" id="chapters" name="chapters" value="<?php echo $row['chapters'] ?>" placeholder="e.g. 45+ or 100/200">
                    </div>

                    <!-- Cover Image -->
                    <div class="form-group">
                        <label for="cover">Cover Image URL *</label>
                        <input type="url" id="cover" name="cover" required value="<?php echo $row['cover'] ?>" placeholder="https://example.com/cover.jpg">
                    </div>

                    <!-- Description -->
                    <div class="form-group full-width">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required placeholder="e.g. A transcendent being has appeared..."><?php echo htmlspecialchars($row['description'] ?? ''); ?></textarea>
                    </div>

                    <!-- Artists -->
                    <div class="form-group">
                        <label for="artists">Artists</label>
                        <input type="text" id="artists" name="artists" required value="<?php echo $row['artists'] ?>" placeholder="e.g. Kim Gamja, Haemoo, Kaji">
                    </div>

                    <!-- Genres -->
                    <div class="form-group">
                        <label for="genres">Genres</label>
                        <input type="text" id="genres-input" name="genres" required value="<?php echo $row['genres'] ?>" placeholder="e.g. Drama, Time Travel">
                    </div>

                    <!-- Themes -->
                    <div class="form-group">
                        <label for="themes">Themes</label>
                        <input type="text" id="themes-input" name="themes" required value="<?php echo $row['themes'] ?>" placeholder="e.g. Time Travel, Acting">
                    </div>

                    <!-- Format -->
                    <div class="form-group">
                        <label for="format">Format</label>
                        <input type="text" id="format" name="format" required value="<?php echo $row['format'] ?>" placeholder="e.g. Long Strip, Full Color">
                    </div>

                    <!-- Publishers -->
                    <div class="form-group">
                        <label for="publishers">Publishers</label>
                        <input type="text" id="publishers-input" name="publishers" required value="<?php echo $row['publishers'] ?>" placeholder="e.g. Kakao, Daum, Mofic">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn" name="edit" onclick='window.location.href="adminListComics.php"'>
                        <i class="fas fa-save"></i> Edit Manga to Database
                    </button>
                </form>
            <?php }
        } else { ?>
            <form action="../Controllers/action_comic.php" method="POST" id="manga-form" class="form-grid">
                <!-- Basic Information -->
                <div class="form-group">
                    <label for="title">Manga Title *</label>
                    <input type="text" id="title" name="title" required placeholder="e.g. The Thousand Faces Actor">
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="" disabled>Select Status</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                        <option value="Hiatus">Hiatus</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="origination">Origination *</label>
                    <select id="origination" name="origination" required>
                        <option value="" disabled>Select Type</option>
                        <option value="Manga">Manga</option>
                        <option value="Manhwa">Manhwa</option>
                        <option value="Manhua">Manhua</option>
                        <option value="Webtoon">Webtoon</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="published_year">Published Year *</label>
                    <input type="number" id="published_year" name="published_year" min="1900" max="2099" required placeholder="e.g. 2025">
                </div>

                <div class="form-group">
                    <label for="chapters">Chapters</label>
                    <input type="text" id="chapters" name="chapters" placeholder="e.g. 45+ or 100/200">
                </div>

                <!-- Cover Image -->
                <div class="form-group">
                    <label for="cover">Cover Image URL *</label>
                    <input type="url" id="cover" name="cover" required placeholder="https://example.com/cover.jpg">
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required placeholder="e.g. A transcendent being has appeared..."></textarea>
                </div>

                <!-- Artists -->
                <div class="form-group">
                    <label for="artists">Artists</label>
                    <input type="text" id="artists" name="artists" required placeholder="e.g. Kim Gamja, Haemoo, Kaji">
                </div>

                <!-- Genres -->
                <div class="form-group">
                    <label for="genres">Genres</label>
                    <input type="text" id="genres-input" name="genres" placeholder="e.g. Drama, Time Travel">
                </div>

                <!-- Themes -->
                <div class="form-group">
                    <label for="themes">Themes</label>
                    <input type="text" id="themes-input" name="themes" placeholder="e.g. Time Travel, Acting">
                </div>

                <!-- Format -->
                <div class="form-group">
                    <label for="format">Format</label>
                    <input type="text" id="format" name="format" placeholder="e.g. Long Strip, Full Color">
                </div>

                <!-- Publishers -->
                <div class="form-group">
                    <label for="publishers">Publishers</label>
                    <input type="text" id="publishers-input" name="publishers" placeholder="e.g. Kakao, Daum, Mofic">
                </div>

                <!-- Submit Button -->
                <button type="submit" name="add" onclick="window.location.href='AdminListComics.php'" class="submit-btn">
                    <i class="fas fa-save"></i> Add Manga to Database
                </button>
            </form>
        <?php } ?>
    </div>
</body>

</html>