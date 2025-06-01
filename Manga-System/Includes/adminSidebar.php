
<!-- Sidebar Navigation -->
<link rel="stylesheet" href="../Style/adminSidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<aside class="sidebar">
    <div class="logo">
        <img src="https://i.imgur.com/JQlE6gN.png" alt="MangaVerse Logo">
        <div class="logo-text">Manga<span>Verse</span></div>
    </div>

    <ul class="nav-menu">
        <li class="nav-title">Dashboard</li>
        <li class="nav-item">
            <a href="../View/adminDashboard.php" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Overview</span>
            </a>
        </li>

        <li class="nav-title">Manga Management</li>
        <li class="nav-item">
            <a href="../View/adminListComics.php" class="nav-link">
                <i class="fas fa-book"></i>
                <span>All Manga</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="../View/adminAddComic.php" class=" nav-link">
                <i class="fas fa-plus-circle"></i>
                <span>Add New Manga</span>
            </a>
        </li>

        <li class="nav-title">User Management</li>
        <li class="nav-item">
            <a href="../View/adminListUsers.php" class="nav-link">
                <i class="fas fa-users"></i>
                <span>All Users</span>
            </a>
        </li>

        <li class="nav-title">System</li>
        <!-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li> -->
        <li class="nav-item">
            <a href="../Controllers/logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>