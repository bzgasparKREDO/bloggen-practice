<?php
session_start();

include 'connection.php';
function addCategory(){
    $conn = connection();
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories(category_name) VALUE ('$category_name')";

    if($conn->query($sql)){
        echo "<div class='mt-5 alert alert-success text-center fw-bold' role='alert'>NEW CATEGORY ADDED: ".$category_name."</div>";
    }else{
        die("Error: " . $conn->error);
    }
}

function displayCategories(){
    $conn = connection();
    $sql = "SELECT * FROM categories ORDER BY category_id DESC";
    
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            return $result;
        }else{
            echo "<tr>
                <td colspan='4' class='text-center'>
                    <p class='lead fw-bold fst-italic mb-0'>No Records Found</p>
                </td>
            </tr>";
        }
    } else {
        die("Error retrieving categories: " . $conn->error);
    }
}
function getCategory($category_id){
    $conn = connection();
    $sql = "SELECT * FROM categories WHERE category_id = $category_id";
    
    if($result = $conn->query($sql)){
        return $result->fetch_assoc();
    } else {
        die("Error: " . $conn->error);
    }
}
function updateCatergory($category_id_u,$category_name_u){
    $conn = connection();

    $sql = "UPDATE `categories` 
            SET `category_name` = '$category_name_u' WHERE `category_id` = '$category_id_u'";

    if($conn->query($sql)){
        echo "<div class='mt-5 alert alert-success text-center fw-bold' role='alert'>CATEGORY Updated: ".$category_name_u."</div>";
    }else{
        die("Error: " . $conn->error);
    }
}
function deleteCategory($category_id){
    $conn = connection();
    $sql = "DELETE FROM categories WHERE category_id = $category_id";

    if($conn->query($sql)){
        echo "<div class='mt-5 alert alert-success text-center fw-bold' role='alert'>CATEGORY Deleted</div>";
    }else{
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
    <title>Blog: Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php include 'admin-menu.php';?>
        <div class="container-fluid bg-success bg-gradient text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-folder mx-1"></i>Category</h2>
        </div>
    </header>

    <main class="container">
        <div class="w-50 mx-auto">
            <?php
                if(isset($_POST['btn_add'])){
                    addCategory();
                }
                if(isset($_POST['btn_delete'])){
                $category_id = $_POST['category_id'];
                    deleteCategory($category_id);
                }     
                if(isset($_POST['btn_update'])){
                    $category_name_u = $_POST['category_name_u'];
                    $category_id_u = $_POST['category_id_u'];
                    updateCatergory($category_id_u,$category_name_u);
                }   
                if(isset($_POST['btn_edit'])){
                    $category_id = $_POST['category_id'];
                    $category = getCategory($category_id);
                    ?>
            <form method="post" class="bg-success p-3 rounded">
                <div class="row">
                    <div class="col text-end">
                        <label for="category-name" class="mt-2 text-white fw-bold">Update Category</label>
                    </div>
                    <div class="col ps-0">
                        <input type="text" name="category_id_u" hidden value="<?= $category['category_id'] ?>">
                        <input type="text" name="category_name_u" value="<?= $category['category_name'] ?>"
                            id="category-name" class="form-control" required autofocus>
                    </div>
                    <div class="col px-0">
                        <button type="submit" name="btn_update"
                            class="btn btn-light text-uppercase fw-bold">Update</button>
                    </div>
                </div>
            </form>
            <?php    
                }else{
                    ?>
            <form method="post">
                <div class="row">
                    <div class="col text-end">
                        <label for="category-name" class="mt-2">Add Category</label>
                    </div>
                    <div class="col ps-0">
                        <input type="text" name="category_name" id="category-name" class="form-control" required
                            autofocus>
                    </div>
                    <div class="col px-0">
                        <button type="submit" name="btn_add" class="btn btn-success text-uppercase fw-bold">Add</button>
                    </div>
                </div>
            </form>
            <?php
                }
            ?>
        </div>

        <table class="table table-striped table-hover w-50 mx-auto text-center mt-5">
            <thead class="table-dark text-uppercase">
                <th>ID</th>
                <th>Name</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php
                $catergories = displayCategories();
                while($category = $catergories->fetch_assoc()){
                    ?>
                <tr>
                    <td><?=$category['category_id'];?></td>
                    <td><?=$category['category_name'];?></td>
                    <td>
                        <form method="post">
                            <input type="text" name="category_id" hidden value="<?= $category['category_id'] ?>">
                            <button type="submit" name="btn_edit"
                                class='btn btn-sm btn-warning text-white'>Update</button>
                        </form>
                    <td>
                        <form method="post">
                            <input type="text" name="category_id" hidden value="<?= $category['category_id'] ?>">
                            <button name="btn_delete" type="submit" href='addtional/edit-catergory.php'
                                class='btn btn-sm btn-danger text-white'>Delete</button>
                        </form>

                    </td>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>

    </main>
</body>

</html>