<?php
session_start();
include 'connection.php';

function displayCategories(){
    $conn = connection();

    $sql = "SELECT * FROM categories";

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            echo "<option value='' hidden>CATEGORY</option>";
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
            }
        }else{
            echo "<option value='' hidden>No Category Found</option>";
        }
    } else {
        die("Error: " . $conn->error);
    }
}

function displayUsers(){
    $conn = connection();
    $sql = "SELECT account_id, username,`role` FROM accounts";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if ($row['account_id'] == $_SESSION['account_id']){
                    echo "<option selected value='".$row['account_id']."'>".$row['username']."</option>";
                    break;
                }
            }
        }else{
            echo "<option value='' hidden>No Records Found</option>";
        }
    } else{
        die("Error: " . $conn->error);
    }
}

function addPost(){
    $conn = connection();
    $title = $_POST['title'];
    $date_posted = $_POST['date_posted'];
    $category_id = $_POST['category_id'];
    $message = $_POST['message'];
    $author_id = $_POST['author_id'];

    $sql = "INSERT INTO posts (post_title, post_message, date_posted, account_id, category_id) VALUES ('$title','$message', '$date_posted', $author_id, $category_id)";
    
    if($conn->query($sql)){
        header("location: posts.php");
        exit;
    }else{
        die("Error: " . $conn->error);
    }
}
if(isset($_POST['add_post'])){
    addPost();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog: Add Post</title>
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
            <h2 class="display-2"><i class="fas fa-pen-nib mx-1"></i>Post</h2>        
        </div>
    </header>
    <main class="container w-50 mx-auto">

        <a href="posts.php" class="text-secondary"><i class="fa-solid mx-1 fa-chevron-left fa-2x"></i></a>

        <h2 class="display-4 text-center my-4"><i class="far fa-edit me-1"></i>Add Post</h2>

        <div class="col-10 mx-auto">
            <form method="post">
                <input type="text" name="title" class="form-control mb-3" placeholder="TITLE" required autofocus>

                <input type="date" name="date_posted" class="form-control mb-3" required>

                <select name="category_id" class="form-select mb-3" required>
                    <?php
                    displayCategories();
                    ?>
                </select>

                <textarea name="message" style="border:none;" class="form-control mb-3" rows="7" placeholder="MESSAGE"></textarea>

                <div class="input-group">
                    <span class="input-group-text bg-dark bg-opacity-75 rounded-0 text-white">Author</span>
                    <select name="author_id" class="form-select">
                        <?php
                        displayUsers();
                        ?>
                    </select>
                </div>
                
                <button type="submit" name="add_post" class="btn btn-primary w-100 mt-5 text-uppercase">Post</button>
            </form>
        </div>
    </main>
</body>

</html>