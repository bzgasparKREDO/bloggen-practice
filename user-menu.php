<nav class="navbar navbar-expand bg-secondary navbar-dark px-5">
    <a href="profile.php" class="navbar-brand">
        <h1 class="h3">Bloggen</h1>
    </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="posts.php" class="nav-link text-white">My Posts</a>
        </li>
        <li class="nav-item">
            <a href="add-post.php" class="nav-link text-white">Add Post</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="profile.php" class="nav-link text-white"><i class="fa-solid mx-1 fa-user text-white mr-1"></i>Welcome <?= $_SESSION['full_name']; ?></a>
        </li>
        <li class="nav-item">
            <a href="logout.php" class="nav-link text-white" ><i class="fa-solid mx-1 fa-user"></i>Logout</a>
        </li>
    </ul>
</nav>
