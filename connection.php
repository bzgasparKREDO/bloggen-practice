<?php
function connection(){
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog";

    $conn = new mysqli($server, $username, $password, $dbname);

    if($conn->connect_error) {
        die("ERROR CONNECTING TO THE DATABASE: " . $conn->connect_error);
    } else {
        return $conn;
    }
}
?>
