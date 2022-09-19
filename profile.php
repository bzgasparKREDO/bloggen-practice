<?php
session_start();
include "connection.php";

function getPassword($account_id) {
    $conn = connection();

    $sql = "SELECT `password` FROM accounts WHERE account_id = $account_id";

    if($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
        return $row['password'];
    }
}

function updateProfile($account_id){
    $conn = connection();
    $password = $_POST['password'];
    $db_password = getPassword($account_id);

    if(password_verify($password, $db_password)){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $contact_number = $_POST['contact_number'];
        $username = $_POST['username'];
        $avatar_name = $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];

        $sql = "UPDATE accounts INNER JOIN users ON users.account_id = accounts.account_id
                SET users.first_name = '$first_name',
                users.last_name = '$last_name',
                users.address = '$address',
                users.contact_number = '$contact_number',
                accounts.username = '$username'
                WHERE accounts.account_id = $account_id";

        if($conn->query($sql)){
            if(!empty($avatar_name)){
                $sql_avatar = "UPDATE users SET avatar = '$avatar_name' WHERE account_id = $account_id";

                $conn->query($sql_avatar);

                if($conn->error){
                    die("Error: " . $conn->error);
                }

                $destination = "images/$avatar_name";
                move_uploaded_file($avatar_tmp, $destination);
            }
            header("location: users.php");
            exit;
        } else {
            die("Error: " . $conn->error);
        }
    } else {
        echo "<div class='alert alert-danger text-center fw-bold' role='alert'>Incorrect password.</div>";
    }    
}
function getProfileDetails($profile_id){
    $conn = connection();
    $sql = "SELECT * FROM accounts INNER JOIN users ON accounts.account_id = users.account_id WHERE accounts.account_id = $profile_id";

    if($result = $conn->query($sql)){
        return $result->fetch_assoc();
    } else {
        die("Error: " . $conn->error);
    }
}
$user_details = getProfileDetails($_SESSION['account_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog: Profile</title>
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
        if ($_SESSION['role'] == "U") {
            include 'user-menu.php';
        } else {
            include 'admin-menu.php';
        }
?>
        <div class="container-fluid bg-info text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-user"></i> Profile</h2>
        </div>
    </header>
    <main class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-8 px-5">
                    <?php
        if (isset($_POST['btn_update'])) {
            updateProfile($_SESSION['account_id']);
        }
?>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="first-name" class="small form-label">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" required autofocus
                                value="<?= $user_details['first_name'] ?>">
                        </div>
                        <div class="col-6">
                            <label for="last-name" class="small form-label">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" required
                                value="<?= $user_details['last_name'] ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="address" class="small form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required
                                value="<?= $user_details['address'] ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="contact-number" class="small form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="contact-number" class="form-control" required
                                value="<?= $user_details['contact_number'] ?>">
                        </div>
                    </div>

                    <label for="username" class="small form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control mb-3" required
                        value="<?= $user_details['username'] ?>">

                    <label for="password" class="small form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter password to confirm" required>

                    <button type="submit" class="btn btn-info text-white text-uppercase mt-4 w-100"
                        name="btn_update">Update</button>
                </div>
                <div class="col-4">
                    <img src="images/<?= $user_details['avatar'] ?>" class='w-100 mb-2'>
                    <input type="file" name="avatar" class="form-control" aria-label="Choose Photo" accept="image/*">
                </div>
            </div>
        </form>
    </main>
</body>

</html>