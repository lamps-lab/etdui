<?php

require_once '../../src/user_list.php';

if (isset($_POST['name'])) {

    session_start();

    $user_list = new UserList();

    $user_list->set_user($_SESSION['user_id']);
    $user_list->set_name($_POST['name']);

    $user_list->create_list();

    header('Location: ../../public/views/lists.php');
}

if (isset($_POST['name2'])) {

    session_start();

    $user_list = new UserList();

    $user_list->set_user($_SESSION['user_id']);
    $user_list->set_name($_POST['name2']);

    $result = $user_list->create_list();

    while ($row = $result->fetch_assoc()) {
        $user_list->set_id($row['id']);
    }

    $list_json = json_encode([
        "userId" => $user_list->get_user(),
        "listId" => $user_list->get_id()
    ]);

    echo $list_json;
}

if (isset($_POST['delete'])) {

    if (isset($_POST['id'])) {

        $user_list = new UserList();

        $user_list->set_id($_POST['id']);

        $user_list->delete_list();
    }
}

if (isset($_POST['delete-all'])) {

    session_start();

    $user_list = new UserList();

    $user_list->set_user($_SESSION['user_id']);

    $user_list->delete_all_lists();
}