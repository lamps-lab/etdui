<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../user.php';

$current_password = $new_password = $email = "";

if (isset($_POST['update_password'])) {
    session_start();

    $user = new User();
    $user->query_by_id($_SESSION['user_id']);

    // Get the inputted current password.
    if (isset($_POST["current_password"])) {
        $current_password = $_POST["current_password"];
    }

    if (isset($_POST["new_password"])) {
        $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    }

    if (password_verify($current_password, $user->get_hashed_password())) {

        if ($user->change_password($new_password)) {
            // If successful, redirect user to the home page.
            echo "<script>window.location = '../../public/views/home.php'; </script>";
        }
    } else {
        // If the password hash does not correlate with the entered password,
        echo "<script>alert('Incorrect password.');
        window.location = '../../public/views/change_password.php';</script>";
    }
}

if (isset($_POST['send_reset_link'])) {
    if (isset($_POST['email'])) {

        $email = $_POST['email'];

        require_once 'handle_email.php';

        send_password_reset($email);
    }

    include '../../public/views/header.php';
    echo '<body>
    <?php include "../../public/views/menu.php" ?>
    
    <div class="flex-center position-ref full-height">
        <div class="card" style="width: 30rem;">
            <div class="card-header"> Password Reset Status</div>
            <div class="card-body" style="color: green;">
                Check your email for the password reset link.
            </div>
        </div>
    </div>
    </body>
    
    </html>';
}
