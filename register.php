<?php
include 'connection.php';
function register(){
    $conn = connection();
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $avatar = 'profile.jpg';
    
    $sql_accounts = "INSERT INTO `accounts` (`username`, `password`) VALUES ('$username', '$password')";

    if($conn->query($sql_accounts)){
        $account_id = $conn->insert_id;

        $sql_users = "INSERT INTO `users` (`first_name`, `last_name`, `address`, `contact_number`, `avatar`, `account_id`) VALUES ('$first_name', '$last_name', '$address','$contact_number', '$avatar', $account_id)";

        if($conn->query($sql_users)){
            header("location: login.php");
            exit;
        }else{
            echo "<div class='alert alert-danger text-center fw-bold' role='alert'>
            Error in USERS Table: ".$conn->error."</div>";
        }
    }else{
        echo "<div class='alert alert-danger text-center fw-bold' role='alert'>
        Error in ACCOUNTS Table: ".$conn->error."</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <div class="card mx-auto w-50 border border-0">
            <div class="card-header bg-white border-0">
                <h1 class="text-center text-uppercase mb-4">Registration</h1>
            </div>
            <div class="card-body">
                <?php
                if(isset($_POST['btn_register'])){
                    register();
                }
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-6  mb-3">
                            <label for="first-name" class=" form-label">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" required autofocus
                                placeholder="First Name">
                        </div>
                        <div class="col-6  mb-3">
                            <label for="last-name" class=" form-label">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" required
                                placeholder="Last Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12  mb-3">
                            <label for="address" class=" form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required
                                placeholder="Address">
                        </div>
                        <div class="col-12  mb-3">
                            <label for="contact-number" class=" form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="contact-number" class="form-control" required
                                placeholder="Contact Number">
                        </div>
                    </div>

                    <label for="username" class=" form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control mb-3" required
                        placeholder="Username">

                    <label for="password" class=" form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        required>
                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" name="btn_register"
                                class="btn btn-success px-5 py-2 text-uppercase">Register</button>
                        </div>
                        <div class="col position-relative">
                            <p class="mb-0 position-absolute" style="bottom: 0; right: 0"><span class="text-dark">Have
                                    an account? </span><a href="login.php">Sign In</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>