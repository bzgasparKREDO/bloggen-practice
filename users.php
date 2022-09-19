<?php
session_start();
include 'connection.php';

function addUser()
{
    $conn = connection();
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $avatar = "profile.jpg";

    $sql_accounts = "INSERT INTO `accounts` (`username`, `password`) VALUES ('$username', '$password')";

    if ($conn->query($sql_accounts)) {
        $account_id = $conn->insert_id;

        $sql_users = "INSERT INTO users (first_name, last_name, `address`, contact_number, avatar, account_id) VALUES ('$first_name', '$last_name', '$address','$contact_number', '$avatar', $account_id)";

        if ($conn->query($sql_users)) {
            echo "<div class='mt-4 alert alert-success text-center fw-bold' role='alert'>NEW USER ADDED: $first_name $last_name</div>";
        } else {
            echo "<div class='alert alert-danger text-center fw-bold' role='alert'>Error: ".$conn->error."
            </div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center fw-bold' role='alert'>
        Error: ".$conn->error."</div>";
    }
}
function getProfileDetails($profile_id)
{
    $conn = connection();
    $sql = "SELECT * FROM `accounts` INNER JOIN `users` ON accounts.account_id = users.account_id WHERE accounts.account_id = '$profile_id'";

    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        die("Error: " . $conn->error);
    }
}
function displayAllUsers()
{
    $conn = connection();

    $sql = "SELECT * FROM users INNER JOIN accounts ON accounts.account_id = users.account_id WHERE accounts.role = 'U'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        echo "<tr>
            <td colspan='7' class='text-center lead fw-bold fst-italic'>
                No Records Found
            </td>
        </tr>";
    }
}
function updateProfile($account_id)
{
    $conn = connection();

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $sql = "UPDATE accounts 
                INNER JOIN users ON users.account_id = accounts.account_id
                SET users.first_name = '$first_name',
                users.last_name = '$last_name',
                users.address = '$address',
                users.contact_number = '$contact_number',
                accounts.username = '$username',
                accounts.password = '$password'
                WHERE accounts.account_id = $account_id";

    if ($conn->query($sql)) {
        echo "<div class='mt-5 alert alert-success text-center fw-bold' role='alert'>User Updated:".$username."</div>";
    } else {
        die("Error: " . $conn->error);
    }
}
function deleteCategory($account_id){
            $conn = connection();
            $sql = "DELETE FROM accounts WHERE account_id = $account_id";

    if($conn->query($sql)){
        $sql = "DELETE FROM users WHERE `user_id` = $account_id";
                    if($conn->query($sql)){
                        echo "<div class='mt-5 alert alert-success text-center fw-bold' role='alert'>User Deleted</div>";
                    }
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
    <title>Blog: User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php include "admin-menu.php";?>
        <div class="container-fluid bg-warning bg-gradient text-white p-4 ps-5">
            <h2 class="display-2"><i class="fa-solid mx-1 fa-user-edit mx-1"></i>User</h2>
        </div>
    </header>
    <main class="container">
        <div class="w-50 mx-auto">
            <?php

            if (isset($_POST['btn_update'])) {
                $user_id = $_POST['user_id'];
                updateProfile($user_id);
            }
            if(isset($_POST['btn_delete'])){
                $user_id = $_POST['user_id'];
                    deleteCategory($user_id);
                }    
            if (isset($_POST['btn_edit'])) {
                $user_id = $_POST['user_id'];
                $user_details= getProfileDetails($user_id);

                ?>
            <form method="post">
                <h3 class="display-4">Update User</h3>
                <div class="row mb-2">
                    <div class="col-6">
                        <input type="text" name="user_id" value="<?= $user_details['user_id'] ?>">
                        <input type="text" name="first_name" value="<?= $user_details['first_name'] ?>"
                            class="form-control" placeholder="First Name" required autofocus>
                    </div>
                    <div class="col-6">
                        <input type="text" name="last_name" value="<?= $user_details['last_name'] ?>"
                            class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <input type="text" name="contact_number" value="<?= $user_details['contact_number'] ?>"
                            class="form-control" placeholder="Contact Number" required>
                    </div>
                    <div class="col-6">
                        <input type="text" name="address" value="<?= $user_details['address'] ?>" class="form-control"
                            placeholder="Address" required>
                    </div>
                </div>
                <input type="text" name="username" value="<?= $user_details['username'] ?>" class="form-control mb-2"
                    placeholder="Username" required>
                <input type="password" name="password" value="<?= $user_details['first_name'] ?>"
                    class="form-control mb-3" placeholder="Password" minlength="8" required>
                <button type="submit" name="btn_update"
                    class="btn btn-warning w-100 text-uppercase text-white fw-bold">Update</button>
            </form>
            <?php
            } else {
                if (isset($_POST['btn_add'])) {
                    addUser();
                }
                ?>
            <form method="post">
                <h3 class="display-4">Add User</h3>
                <div class="row mb-2">
                    <div class="col-6">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required
                            autofocus>
                    </div>
                    <div class="col-6">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <input type="text" name="contact_number" class="form-control" placeholder="Contact Number"
                            required>
                    </div>
                    <div class="col-6">
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                    </div>
                </div>
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" minlength="8"
                    required>
                <button type="submit" name="btn_add"
                    class="btn btn-warning w-100 text-uppercase text-white fw-bold">Add</button>
            </form>
            <?php
            }

?>

        </div>

        <table class="table table-hover table-striped my-5">
            <thead class="table-dark text-uppercase">
                <th>User ID</th>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Username</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php
        $users = displayAllUsers();
while ($user = $users->fetch_assoc()) {
    ?>
                <tr>
                    <td><?= $user['user_id']?></td>
                    <td><?= $user['first_name']." " . $user['last_name']?></td>
                    <td><?= $user['contact_number']?></td>
                    <td><?= $user['address']?></td>
                    <td><?= $user['username']?></td>
                    <td>
                        <form method="post">
                            <input type="text" name="user_id" hidden value="<?= $user['user_id']?>">
                            <button name="btn_edit" type="submit"
                                class='btn btn-sm btn-warning text-white'>Update</button>
                        </form>
                    </td>
                    <td>
                    <form method="post">
                            <input type="text" name="user_id" hidden value="<?= $user['user_id']?>">
                            <button name="btn_delete" type="submit"
                                class='btn btn-sm btn-danger text-white'>Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
}?>
            </tbody>
        </table>
    </main>
</body>

</html>