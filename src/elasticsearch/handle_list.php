<?php

require_once '../../src/user_list.php';

if (isset($_POST['name'])) {

    session_start();

    $user_list = new UserList();

    $user_list->set_user($_SESSION['user_id']);
    $user_list->set_name($_POST['name']);

    // Creates list with the given name and user ID.

    $user_list->create_list();

    header('Location: ../../public/views/lists.php');
}

if (isset($_POST['delete'])) {

    // Deletes the users list.

    if (isset($_POST['id'])) {

        $user_list = new UserList();

        $user_list->set_id($_POST['id']);

        $user_list->delete_list();
    }
}

if (isset($_POST['delete-all'])) {

    // Deletes all of the lists by a user.
    
    session_start();

    $user_list = new UserList();

    $user_list->set_user($_SESSION['user_id']);

    $user_list->delete_all_lists();
}