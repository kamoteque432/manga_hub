<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}

// Verify user is admin
require_once '../Model/user.php';
$user = new User();
$current_user = $user->getUserById($_SESSION['user_id']);

if (!$current_user) {
    unset($_SESSION['user_id']);
    header("Location: ../View/login.php");
    exit();
}

$role = trim($user->getUserRole($current_user['email']));
if (strcasecmp($role, 'Admin') !== 0) {
    header("Location: ../View/userInfo.php");
    exit();
}

// Only proceed if authenticated admin
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List | Admin Dashboard</title>
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
                    <h4><i class="fas fa-users"></i> List of Users</h4>
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
                                if ($users) {
                                    foreach ($users as $row) {
                                        // Skip admin users
                                        if (strcasecmp(trim($row['role']), 'Admin') === 0) {
                                            continue;
                                        }
                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row["username"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn-delete" href="../Controllers/action_user.php?delete=<?php echo htmlspecialchars($row['user_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #888;">No non-admin users found.</td></tr>';
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