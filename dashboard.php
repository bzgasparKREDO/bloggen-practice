<?php
session_start();
include "connection.php";

function displayAllPosts(){
    $conn = connection();

    $sql = "SELECT * FROM posts INNER JOIN categories ON categories.category_id = posts.category_id INNER JOIN accounts ON accounts.account_id = posts.account_id ORDER BY date_posted DESC";

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['account_id'] == $_SESSION['account_id']){
                    echo "
                    <tr>
                        <td>".$row['post_id']."</td>
                        <td>".$row['post_title']."</td>
                        <td>".$row['username']."</td>
                        <td>".$row['category_name']."</td>
                        <td>".$row['date_posted']."</td>
                        <td>
                            <a href='post-details.php?post_id=".$row['post_id']."' class='btn btn-sm btn-outline-dark'><i class='fa-solid mx-1 fa-angle-double-right'></i> Details</a>
                        </td>
                    </tr>
                ";
                }else{
                    echo "
                    <tr>
                        <td>".$row['post_id']."</td>
                        <td>".$row['post_title']."</td>
                        <td>".$row['username']."</td>
                        <td>".$row['category_name']."</td>
                        <td>".$row['date_posted']."</td>
                        <td>
                        </td>
                    </tr>
                ";
                }
            }
        } else {
            echo "<tr>
                <td colspan='5' class='text-center lead fst-italic fw-bold'>
                    No Records Found
                </td>
            </tr>";
        }
    } else {
        die("Error: " . $conn->error);
    }
}
function countPosts($account_id){
    $conn = connection();
    $sql = "SELECT COUNT(post_id) AS post_count FROM posts WHERE account_id = $account_id";

    if($result = $conn->query($sql)){
        $result_assoc = $result->fetch_assoc();
        return $result_assoc['post_count'];
    } else {
        die("Error: " . $conn->error);
    }
}

function countCategories(){
    $conn = connection();
    $sql = "SELECT COUNT(category_id) AS category_count FROM categories";

    if($result = $conn->query($sql)){
        $result_assoc = $result->fetch_assoc();
        return $result_assoc['category_count'];
    } else {
        die("Error: " . $conn->error);
    }
}

function countUsers(){
    $conn = connection();
    $sql = "SELECT COUNT(account_id) AS users_count FROM accounts WHERE `role` = 'U'";

    if($result = $conn->query($sql)){
        $result_assoc = $result->fetch_assoc();
        return $result_assoc['users_count'];
    } else {
        die("Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog: Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php include "admin-menu.php"; ?>
        <div class="container-fluid bg-danger bg-gradient text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-user-cog mx-1"></i>Dashboard</h2>
        </div>
    </header>
    <div class="container-fluid bg-light p-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a class="btn btn-primary d-block" href="add-post.php"><i class="fa-solid mx-1 fa-plus-circle me-2"></i>Add Post</a>
                </div>
                <div class="col">
                    <a class="btn btn-success d-block" href="categories.php"><i class="fa-solid mx-1 fa-folder-plus me-2"></i>Add Category</a>
                </div>
                <div class="col">
                    <a class="btn btn-warning text-white d-block" href="users.php"><i class="fa-solid mx-1 fa-user-plus me-2"></i>Add User</a>
                </div>
            </div>
        </div>
    </div>

    <main class="container">
        <h3 class="h4 text-muted fw-bold text-uppercase">All Posts</h3>
        <div class="row">
            <div class="col-9">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Date Posted</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php
                        displayAllPosts();
                    ?>
                    </tbody>
                </table>
            </div> 
            <nav class="col-3">
                <div class="card bg-primary mb-4 border-5">
                    <div class="card-body text-center text-white">
                        <h3>Posts</h3>
                        <p class="fs-4"><i class="fas fa-pencil-alt"></i> <?= countPosts($_SESSION['account_id']); ?></p>
                        <a href="posts.php" class="btn btn-outline-light btn-sm fw-bold text-uppercase">view</a>
                    </div>
                </div>
                
                <div class="card bg-success mb-4 border-5">
                    <div class="card-body text-center text-white">
                        <h3>Categories</h3>
                        <p class="fs-4"><i class="far fa-folder-open"></i> <?= countCategories();?></p>
                        <a href="categories.php" class="btn btn-outline-light btn-sm fw-bold text-uppercase">view</a>
                    </div>
                </div>

                <div class="card bg-warning border-5">
                    <div class="card-body text-center text-white">
                        <h3>Users</h3>
                        <p class="fs-4"><i class="fas fa-users"></i> <?= countUsers();?></p>
                        <a href="users.php" class="btn btn-outline-light btn-sm fw-bold text-uppercase">view</a>
                    </div>
                </div>
            </nav>
        </div>
    </main>
    
</body>

</html>