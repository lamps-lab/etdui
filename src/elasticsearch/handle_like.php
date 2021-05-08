<?php

session_start();

require '../../vendor/autoload.php';
include '../mysql_login.php';
require_once '../../src/figure.php';

if (isset($_POST['figure_id'])) {

    $user_id = $_SESSION['user_id'];

    $figure = new Figure();

    // Set the dissertation ID.
    $figure->set_id($_POST['figure_id']);

    if ($figure->liked_by_user($user_id)) {
        $figure->unlike_figure($user_id);
        // Return 0 for unliking a dissertation.
        echo 0;
    } else {
        $figure->like_figure($user_id);
        // Return 1 for liking a dissertation.
        echo 1;
    }
}

if (isset($_POST['redirect'])) {
    header('Location: ../../public/views/likes.php');
}
