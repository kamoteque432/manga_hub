<?php

include "../Model/user.php";
$user = new User();

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
                    <h4><i class="fas fa-book"></i> List of Users</h4>
                </div>
                <div class="custom-card-body">
                    <div class="custom-table-responsive">
                        <table class="custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $users = $user->getAllUsers(); // Hypothetical method

                                if ($users) {
                                    foreach ($users as $row) {
                                        // Assuming your user model has a 'cover' field with image URL
                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row["username"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn-delete" href="../Controllers/action_user.php?delete=<?php echo $row['user_id'] ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                    <a href="adminEditUser.php?edit=<?php echo $row['user_id'] ?>" class="btn-edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
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