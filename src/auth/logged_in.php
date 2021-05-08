<?php

session_start();

require_once '../../src/user.php';

if (isset($_SESSION['user_id'])) {
    
    $user = new User();
    $user->query_by_id($_SESSION['user_id']);
    
    // If logged in, display logout button.
    echo "<li class='menu' style='float:right'><a class='menu' href='../../src/auth/logout_action.php'>LOG OUT</a></li>";
    // If logged in, display username.
    $uppercase_username = strtoupper($user->get_name());
    echo "<li class='menu' style='float:right'> <a class='menu' href='../../public/views/home.php'>WELCOME, ".$uppercase_username."</a></li>";
} else {
    // If not logged in, add the log in and sign up links to the menu.
    echo "<li class='menu' style='float:right'><a class='menu' href='../../public/views/registration.php'>REGISTER</a></li>";
    echo "<li class='menu' style='float:right'><a class='menu' href='../../public/views/login.php'>LOG IN</a></li>";
}
