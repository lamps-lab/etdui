<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
include '../mysql_login.php';

require_once '../../src/dissertation.php';

session_start();

if (isset($_POST['dissertation_id'])) {

    $user_id = $_SESSION['user_id'];

    $dissertation = new Dissertation();

    // Set the dissertation ID.
    $dissertation->set_id($_POST['dissertation_id']);

    if ($dissertation->is_saved($user_id)) {

        // If the dissertation is saved in the current user's
        // saved dissertations, call the remove dissertation function.
        $dissertation->removeDissertation($user_id);
    } else {
        // If the dissertation is not saved in the current user's 
        // saved dissertations, call the save dissertation function.
        $dissertation->saveDissertation($user_id);
    }
}

