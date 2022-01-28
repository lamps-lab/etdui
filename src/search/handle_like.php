<?php

session_start();

require '../../vendor/autoload.php';
include '../mysql_login.php';
require_once '../../src/dissertation.php';

if (isset($_POST['dissertation_id'])) {

    $user_id = $_SESSION['user_id'];

    $dissertation = new Dissertation();

    // Set the dissertation ID.
    $dissertation->set_id($_POST['dissertation_id']);

    if ($dissertation->liked_by_user($user_id)) {
        $dissertation->unlike_dissertation($user_id);
        // Return 0 for unliking a dissertation.
        echo 0;
    } else {
        $dissertation->like_dissertation($user_id);
        // Return 1 for liking a dissertation.
        echo 1;
    }
}

if (isset($_POST['redirect'])) {
    header('Location: ../../public/views/likes.php');
}
