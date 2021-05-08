<?php

require '../../vendor/autoload.php';
include '../mysql_login.php';

require_once '../../src/figure.php';

session_start();

if (isset($_POST['figure_id'])) {

    $user_id = $_SESSION['user_id'];

    $figure = new Figure();

    // Set the dissertation ID.
    $dissertation->set_id($_POST['figure_id']);

    if ($figure->is_saved($user_id)) {

        // If the dissertation is saved in the current user's
        // saved dissertations, call the remove dissertation function.
        $figure->remove_figure($user_id);
    } else {
        // If the dissertation is not saved in the current user's 
        // saved dissertations, call the save dissertation function.
        $figure->save_figure($user_id);
    }
}

