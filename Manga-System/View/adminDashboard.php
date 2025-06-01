<?php

session_start();

// Redirect to login if not authenticated or not admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../View/login.php");
    exit();
}

require_once '../Model/user.php';
require_once '../Model/comic.php';
$user = new User();
$comic = new Comic();

// Get user data and verify role
$user_login = $user->getUserById($_SESSION['user_id']);
if (!$user_login) {
    unset($_SESSION['user_id']);
    header("Location: ../View/login.php");
    exit();
}

// Check if user is admin
$role = trim($user->getUserRole($user_login['email']));
if (strcasecmp($role, 'Admin') !== 0) {
    header("Location: ../View/userInfo.php");
    exit();
}

$totalUsers = $user->getUserCount();
$totalBooks = $comic->getTotalComicsCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaVerse Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff4d7a;
            --secondary: #6b5b95;
            --accent: #61dafb;
            --dark: #101623;
            --sidebar: #1a2238;
            --card-bg: #1e293b;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--dark);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            transition: all 0.3s;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: white;
            font-family: 'Mochiy Pop One', sans-serif;
        }

        .page-title i {
            color: var(--primary);
            margin-right: 10px;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .notification {
            position: relative;
            margin-right: 1.5rem;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--primary);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-weight: 500;
            margin-right: 5px;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.5rem;
        }

        .stat-icon.primary {
            background-color: rgba(255, 77, 122, 0.2);
            color: var(--primary);
        }

        .stat-icon.secondary {
            background-color: rgba(107, 91, 149, 0.2);
            color: var(--secondary);
        }

        .stat-icon.accent {
            background-color: rgba(97, 218, 251, 0.2);
            color: var(--accent);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 0.2rem;
        }

        .stat-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Content Sections */
        .content-section {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .section-title i {
            color: var(--primary);
            margin-right: 10px;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #ff3d6d;
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        th {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:hover td {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .status {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status.ongoing {
            background-color: rgba(97, 218, 251, 0.2);
            color: var(--accent);
        }

        .status.completed {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status.hiatus {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .user-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--secondary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            overflow: hidden;
        }

        .user-avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            color: var(--accent);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-menu {
                margin-top: 1rem;
            }
        }

        /* Toggle Button for Mobile */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
        }
        a{
            text-decoration: none;
            color: white;
            font-weight: 400;
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    <?php include "../Includes/adminSidebar.php" ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard Overview
            </h1>
            <div class="user-menu">
                <div class="notification">
                    
                    
                </div>
                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="https://ih1.redbubble.net/image.5269398975.6668/raf,360x360,075,t,fafafa:ca443f4786.u6.jpg" alt="Admin Avatar">
                    </div>
                    <span class="user-name"><?php echo $user_login['username']; ?></span>
                    
                </div>
            </div>
        </div>

    <!-- Stats Cards  -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalBooks;?></h3>
                    <p>Total Manga</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalUsers;?></h3>
                    <p>Registered Users</p>
                </div>
            </div>
            <!-- <div class="stat-card">
                <div class="stat-icon accent">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-info">
                    <h3>24,569</h3>
                    <p>Daily Views</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="stat-info">
                    <h3>342</h3>
                    <p>New Comments</p>
                </div>
            </div> -->
        </div>

        <!-- Recent Manga Section 
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-book"></i>
                    Recent Manga
                </h2>
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> <a href="../View/adminAddComic.php">Add New</a>
                </button>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Chapters</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="https://meo.comick.pictures/5pMrqZ-m.jpg" width="50" height="70" style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>The Thousand Faces Actor</td>
                            <td><span class="status ongoing">Ongoing</span></td>
                            <td>45+</td>
                            <td>2023-05-15</td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://i.imgur.com/5QX2Q1r.jpg" width="50" height="70" style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>Attack on Titan</td>
                            <td><span class="status completed">Completed</span></td>
                            <td>139</td>
                            <td>2023-01-10</td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://i.imgur.com/8XJQ2Zr.jpg" width="50" height="70" style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>Demon Slayer</td>
                            <td><span class="status completed">Completed</span></td>
                            <td>205</td>
                            <td>2023-03-22</td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://i.imgur.com/3QX2Q1r.jpg" width="50" height="70" style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>One Piece</td>
                            <td><span class="status ongoing">Ongoing</span></td>
                            <td>1,045+</td>
                            <td>2023-02-05</td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://i.imgur.com/7QX2Q1r.jpg" width="50" height="70" style="object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>Jujutsu Kaisen</td>
                            <td><span class="status hiatus">Hiatus</span></td>
                            <td>187</td>
                            <td>2023-04-18</td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- Recent Users Section -->
        <!-- <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-users"></i>
                    Recent Users
                </h2>
                <button class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar-sm">
                                        <img src="https://i.imgur.com/JQlE6gN.png">
                                    </div>
                                    <span>MangaFan123</span>
                                </div>
                            </td>
                            <td>mangafan@example.com</td>
                            <td>2023-06-10</td>
                            <td><span class="status ongoing">Active</span></td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Ban">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="action-btn" title="Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar-sm">
                                        <img src="https://i.imgur.com/JQlE6gN.png">
                                    </div>
                                    <span>AnimeLover</span>
                                </div>
                            </td>
                            <td>anime.lover@example.com</td>
                            <td>2023-06-08</td>
                            <td><span class="status ongoing">Active</span></td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Ban">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="action-btn" title="Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar-sm">
                                        <img src="https://i.imgur.com/JQlE6gN.png">
                                    </div>
                                    <span>WebtoonReader</span>
                                </div>
                            </td>
                            <td>webtoon@example.com</td>
                            <td>2023-06-05</td>
                            <td><span class="status completed">Banned</span></td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Unban">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="action-btn" title="Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar-sm">
                                        <img src="https://i.imgur.com/JQlE6gN.png">
                                    </div>
                                    <span>ShonenKing</span>
                                </div>
                            </td>
                            <td>shonen@example.com</td>
                            <td>2023-06-01</td>
                            <td><span class="status ongoing">Active</span></td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Ban">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="action-btn" title="Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar-sm">
                                        <img src="https://i.imgur.com/JQlE6gN.png">
                                    </div>
                                    <span>ShojoQueen</span>
                                </div>
                            </td>
                            <td>shojo@example.com</td>
                            <td>2023-05-28</td>
                            <td><span class="status hiatus">Inactive</span></td>
                            <td>
                                <button class="action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn" title="Ban">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button class="action-btn" title="Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main> -->

    <script>
        // Simple script for mobile menu toggle (no functionality)
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>