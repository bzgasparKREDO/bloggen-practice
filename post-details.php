<?php
session_start();
include 'connection.php';

function getPostDetails($post_id){
    $conn = connection();
    
    $sql = "SELECT * FROM posts 
            INNER JOIN categories ON categories.category_id = posts.category_id 
            INNER JOIN users ON users.account_id = posts.account_id 
            WHERE post_id = $post_id";

    if($result = $conn->query($sql)){
        return $result->fetch_assoc();
    } else {
        die("Error: ". $conn->error);
    }        
}
$post_row = getPostDetails($_GET['post_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog: Post Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php 
        if($_SESSION['role'] == "U"){
            include 'user-menu.php';
        } else {
            include 'admin-menu.php';
        }
        ?>
        <div class="container-fluid bg-primary bg-gradient text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-pen-nib mx-1"></i>Post</h2>        
        </div>
    </header>
    <main class="container w-50 ">
        <div class="row mb-4">
            <a href="posts.php" class="text-secondary col"><i class="fa-solid mx-1 fa-chevron-left fa-2x"></i></a>
                <a href="edit-post.php?post_id=<?= $_GET['post_id'] ?>" class="text-secondary col text-end text-decoration-none" style="font-size: 1.5em"><i class="fa-solid mx-1 fa-pen me-1"></i>Edit</a>
        </div>

        <article class="bg-light p-3">
            <h1 class="display-5"><?= $post_row['post_title'] ?></h1>
            <p class="small">
                By: <span class="text-primary"><?= $post_row['first_name']." ".$post_row['last_name'] ?></span>
                &emsp;
                <?= date("F d, Y", strtotime($post_row['date_posted'])) ?>
                &emsp;
                <?= $post_row['category_name'] ?>
            </p>

            <p class="lead mt-5"><?= nl2br($post_row['post_message']) ?></p>
        </article>
    </main>
</body>

</html>