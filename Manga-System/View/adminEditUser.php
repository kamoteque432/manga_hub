<?php

include "../Model/user.php";

// Redirect to login.php if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user = new User();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/adminEditUser.css">
</head>

<body>
    <?php include "../Includes/adminSidebar.php" ?>

    <!-- Floating decorative elements -->
    <div class="floating floating-1">✧</div>
    <div class="floating floating-2">♡</div>

    <div class="center-wrapper">
        <div class="main-content">
            <div class="form-header">
                <h1><i class="fas fa-user-edit"></i> Edit User Profile</h1>
                <p>Update user information and permissions</p>
            </div>

            <?php
            if (isset($_GET['edit'])) {
                $get_id_edit = $_GET['edit'];
                $row = $user->getUserById($get_id_edit);
                if ($row) { ?>
                    <form action="../Controllers/action_user.php" method="POST" id="userEditForm">
                        <!-- Email Field -->
                        <input type="text" value="<?php echo $row["user_id"] ?>" name="user_id" hidden>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="user@example.com"
                                value="<?= htmlspecialchars($row['email']) ?>"
                                required>
                        </div>

                        <!-- Username Field -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-control"
                                placeholder="Enter username"
                                value="<?= htmlspecialchars($row['username']) ?>"
                                required>
                        </div>

                        <!-- Role Field -->
                        <?php
                        $role = strtolower(trim($row['role']));
                        ?>
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="" disabled>Select Role</option>
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Leave blank to keep current password">
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input
                                type="password"
                                id="confirmPassword"
                                name="confirmPassword"
                                class="form-control"
                                placeholder="Confirm new password">
                        </div>

                        <div class="btn-group">
                            <button type="submit" name="edit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <button type="button" onclick="window.location.href='adminListUsers.php'" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>