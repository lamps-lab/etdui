<?php

session_start();

require_once '../user.php';

$user = new User();

$user->query_by_id($_SESSION['user_id']);

$username = $password = "";

// Get the inputted username.
if (isset($_POST["username"])) {
    $username = $_POST["username"];
}

// Get the inputted password.
if (isset($_POST["password"])) {
    $password = $_POST["password"];
}


if ($user->name_used($username)) {
    echo "<script> alert('The username is already taken.');
    window.location = '../../public/views/change_username.php'; </script>";
} else {

    if (password_verify($password, $user->get_hashed_password())) {
        if ($user->change_username($username)) {
            // If password is successfully changed, redirect user to home screen.
            echo "<script>window.location = '../../public/views/home.php'; </script>";
        }
    } else {
        // If the password hash does not correlate with the entered password,
        echo "<script>alert('Incorrect password.');
            window.location = '../../public/views/change_username.php';</script>";
    }
}

$connection->close();
