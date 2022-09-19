<?php
session_start();
include 'connection.php';


function displayCategories(){
    $conn = connection();

    $post_row = getPostDetails($_GET['post_id']);
    $category_id= $post_row['category_id'] ;

    $sql = "SELECT * FROM `categories`";

    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            echo "<option value='' hidden>CATEGORY</option>";
            while($row = $result->fetch_assoc()){
                if ($row['category_id'] == $category_id){
                    echo "<option selected value='".$row['category_id']."'>".$row['category_name']."</option>";
                    }else{
                    echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
                    }   
            }
        }else{
            echo "<option value=''>No Category Found</option>";
        }
    } else {
        die("Error: " . $conn->error);
    }
}
$post_row = getPostDetails($_GET['post_id']);
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

function updatePost($post_id){
    $conn = connection();
    $title = $_POST['title'];
    $date_posted = $_POST['date_posted'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['account_id'];
    $message = $_POST['message'];

    $sql = "UPDATE posts 
            SET post_title = '$title',
                date_posted = '$date_posted',
                category_id = $category_id,
                post_message = '$message',
                account_id = $author_id
            WHERE post_id = $post_id";

    if($conn->query($sql)){
        header("location: post-details.php?post_id=".$post_id);
        exit;
    }else{
        die("Error: " . $conn->error);
    }
}
if(isset($_POST['btn_update'])){
    updatePost($_GET['post_id']);        
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog: Update Post</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php 
        include 'admin-menu.php';
        ?>
        <div class="container-fluid bg-primary bg-gradient text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-pen-nib mx-1"></i>Post</h2>
        </div>
    </header>
    <main class="container w-50 mx-auto">

        <a href="post-details.php?post_id=<?= $_GET['post_id'] ?>" class="text-secondary"><i
                class="fa-solid mx-1 fa-chevron-left fa-2x"></i></a>

        <h2 class="display-4 text-center my-4"><i class="fa-solid mx-1 fa-pen"></i> Update Post</h2>

        <div class="col-10 mx-auto">
            <form method="post">
                <input type="text" name="title" class="form-control mb-3" placeholder="TITLE"
                    value="<?= $post_row['post_title'] ?>" required autofocus>

                <input type="date" name="date_posted" class="form-control mb-3" value="<?= $post_row['date_posted'] ?>"
                    required>

                <select name="category_id" class="form-select mb-3" required>
                    <?php
                    displayCategories($post_row['category_id']);
                    ?>
                </select>

                <textarea name="message" style="border: solid 2px black ;" class="form-control mb-3" rows="7"
                    placeholder="MESSAGE"><?= $post_row['post_message'] ?></textarea>

                <button type="submit" name="btn_update" class="btn btn-dark w-100 mt-5 text-uppercase">Update</button>
            </form>
        </div>
    </main>
</body>

</html>