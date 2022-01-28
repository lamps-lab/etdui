<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../user.php';
include '../../constants.php';

session_start();

if (isset($_POST['submit'])) {

    $response_key = $_POST["gRecaptchaResponse"];
    
    $user_ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" .
        SECRET_KEY . "&response=" . $response_key . "&remoteip=" . $user_ip;

    $response = json_decode(file_get_contents($url));

    if ($response->success) {
        // Initialize variables.
        $email = $password = $username = "";

        // Get the inputted email.
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
        }

        // Get the inputted password.
        if (isset($_POST["password"])) {
            $password = $_POST["password"];
        }

        $user = new User();

        // If the email is not present in the table, inform the user.
        if (!$user->email_used($email)) {
            echo 0;
        } else {

            if ($user->login($email, $password)) {
                
                $file_name = ETD_LOGS_PATH . explode("@", $email)[0] . ".txt";
                // echo $file_name;
                $log_file = fopen($file_name, "a");
                $date = date('m/d/Y h:i:s a', time());
                $data = "$date: Logged In\n";
                fwrite($log_file, $data);
                echo 1;
            } else {
                echo 2;
            }
        }
    } else {
        echo 3;
    }
}
