<?php
include 'connection.php';
function login(){
    $conn = connection();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = "<div class='alert alert-danger text-center fw-bold' role='alert'>Incorrect Username or Password</div>";

    $sql = "SELECT * FROM accounts WHERE username = '$username'";

    if($result = $conn->query($sql)){
        if($result->num_rows == 1){
            $user_details = $result->fetch_assoc();
            if(password_verify($password, $user_details['password'])){
                session_start();
                $_SESSION['account_id'] = $user_details['account_id'];
                $_SESSION['role'] = $user_details['role'];
                $_SESSION['full_name'] = getFullName($user_details['account_id']);

                if($user_details['role'] == 'A'){
                    header("location: dashboard.php");
                }elseif($user_details['role'] == 'U'){
                    header("location: profile.php");
                }
                exit;
            } else{
            echo $error;
            }
        }else{
            echo $error;
        }
    } else {
        die("Error: " . $conn->error);
    }
}

function getFullName($account_id){
    $conn = connection();
    $sql = "SELECT first_name, last_name FROM users WHERE account_id = $account_id";

    if($result = $conn->query($sql)){
        $full_name = $result->fetch_assoc();
        return $full_name['first_name'] . " " . $full_name['last_name'];
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
    <meta http-equiv="X-UA-zCompatible" content="ie=edge">
    <title>Login</title>
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
                <h1 class="text-center text-uppercase mb-4">Login</h1>
            </div>
            <div class="card-body">
                <?php
                if (isset($_POST['btn_login'])) {
                    login();
                }
                ?>
                <form action="" method="post">
                    <input type="text" name="username" class="form-control mb-4" placeholder="USERNAME" required autofocus>
                    <input type="password" name="password" class="form-control mb-5" placeholder="PASSWORD" required>
                    <button type="submit" name="btn_login" class="btn btn-success text-uppercase py-2 w-100">Enter</button>
                </form>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="row">
                    <div class="col-6 text-center">
                        <a href="register.php" class="text-decoration-none text-dark">Create an Account</a>
                    </div>
                    <div class="col-6 text-center">
                        <h6><a href="recover.php" class="text-decoration-none text-dark">Recover Account</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>