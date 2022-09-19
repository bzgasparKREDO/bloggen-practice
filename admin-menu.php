<nav class="navbar navbar-expand-md bg-dark navbar-dark px-5">
    <a href="dashboard.php" class="navbar-brand">
        <h1 class="h3">Bloggen</h1>
    </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="users.php" class="nav-link text-white">Users</a>
        </li>
        <li class="nav-item">
            <a href="posts.php" class="nav-link text-white">Posts</a>
        </li>
        <li class="nav-item">
            <a href="categories.php" class="nav-link text-white">Categories</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="profile.php" class="nav-link text-white"><i class="fa-solid mx-1 fa-user"></i>Welcome <?= $_SESSION['full_name'] ?></a>
        </li>
        <li class="nav-item">
            <a href="logout.php" class="nav-link text-white"><i class="fa-solid mx-1 fa-user"></i>Logout</a>
        </li>
    </ul>
</nav>