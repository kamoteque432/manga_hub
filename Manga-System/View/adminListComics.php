<?php

include "../Model/comic.php";
$comic = new Comic();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga List | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <?php include "../Includes/href.php" ?>
    <link rel="stylesheet" href="../Style/adminListComics.css">
</head>

<body>
    <?php include "../Includes/adminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="manga-table-container">
            <div class="custom-card">
                <div class="custom-card-header">
                    <h4><i class="fas fa-book"></i> List of Mangas</h4>
                    <div class="search-filter">
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Ongoing</option>
                            <option>Completed</option>
                            <option>Hiatus</option>
                        </select>
                    </div>
                </div>
                <div class="custom-card-body">
                    <div class="custom-table-responsive">
                        <table class="custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Genre</th>
                                    <th>Description</th>
                                    <th>Year</th>
                                    <th>Chapters</th>
                                    <th>Status</th>
                                    <th>Author/Artist</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $comics = $comic->getAllComics(); // Hypothetical method

                                if ($comics) {
                                    foreach ($comics as $row) {
                                        // Assuming your comic model has a 'cover' field with image URL
                                        $coverImage = !empty($row['cover']) ? $row['cover'] : 'https://via.placeholder.com/60x80/1e293b/94a3b8?text=No+Cover';
                                ?>
                                        <tr>
                                            <td><img src="<?php echo $coverImage; ?>" class="manga-cover" alt="<?php echo htmlspecialchars($row["title"]); ?>"></td>
                                            <td><?php echo htmlspecialchars($row["title"]); ?></td>
                                            <td><?php echo htmlspecialchars($row['genres']); ?></td>
                                            <td>
                                                <?php
                                                $desc = htmlspecialchars($row["description"]);
                                                echo strlen($desc) > 60 ? substr($desc, 0, 58) . "..." : $desc;
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['published_year']); ?></td>
                                            <td><?php echo htmlspecialchars($row['chapters']); ?></td>
                                            <td class="status" data-status="<?php echo strtolower($row['status']); ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['artists']); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn-delete" href="../Controllers/action_comic.php?delete=<?php echo $row['comic_id'] ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                    <a href="adminAddComic.php?edit=<?php echo $row['comic_id'] ?>" class="btn-edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="9" style="text-align: center; padding: 20px; color: #888;">No mangas found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>