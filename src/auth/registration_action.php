<?php

require_once '../user.php';
include '../../constants.php';

if (isset($_POST['submit'])) {
    // Initialize all of the registration variables.
    $email = $username = $password = $confirm_password = "";

    $passwords_confirmed = $email_valid = $username_valid = $captcha_confirmed = false;

    $response_key = $_POST["gRecaptchaResponse"];
    $user_ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" .
        SECRET_KEY . "&response=" . $response_key . "&remoteip=" . $user_ip;

    $response = json_decode(file_get_contents($url));

    // Get the inputted email.
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }

    // Get the inputted username.
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
    }

    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }

    if (isset($_POST["confirmPassword"])) {
        $confirm_password = $_POST["confirmPassword"];
    }

    if ($password == $confirm_password) {
        $passwords_confirmed = true;
    } else {
        echo 0;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $user = new User();

    // If email is already in the users table, warn the user.
    if ($user->email_used($email)) {
        echo 1;
    } else {
        $email_valid = true;
    }

    if ($user->name_used($username)) {
        echo 2;
    } else {
        $username_valid = true;
    }

    if ($response->success) {
        $captcha_confirmed = true;
    } else {
        echo 3;
    }

    if ($email_valid && $username_valid && $passwords_confirmed && $captcha_confirmed) {
        if ($user->register($email, $username, $password)) {
            echo 4;
        }
    }
}
