<?php
session_start();
include 'connection.php';

function displayUserPosts($user_id){
    $conn = connection();

    $sql = "SELECT * FROM posts INNER JOIN categories ON categories.category_id = posts.category_id WHERE account_id = $user_id ORDER BY date_posted DESC";

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "
                    <tr>
                        <td>".$row['post_id']."</td>
                        <td>".$row['post_title']."</td>
                        <td>".$row['category_name']."</td>
                        <td>".$row['date_posted']."</td>
                        <td>
                            <a href='post-details.php?post_id=".$row['post_id']."' class='btn btn-sm btn-outline-dark'><i class='fa-solid mx-1 fa-angle-double-right'></i> Details</a>
                        </td>
                    </tr>
                ";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog: Post</title>
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
        <div class="container-fluid bg-info text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-pen-nib mx-1"></i>Post</h2>        
        </div>
    </header>

    <main class="container">
        <div class="text-end">
            <a href="add-post.php" class="btn btn-lg btn-outline-dark"><i class="fa-solid mx-1 fa-edit"></i> Add Post</a>
        </div>
        <table class="table table-hover table-striped mt-3">
            <thead class="table-dark">
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date Posted</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                displayUserPosts($_SESSION['account_id']);
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>