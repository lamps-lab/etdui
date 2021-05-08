<?php

if (isset($_POST['handle'])) {

    require_once '../../src/user_list.php';

    $figure_id = $_POST['figure_id'];

    $user_list = new UserList();
    $user_list->set_id($_POST['list_id']);
    $user_list->set_user($_POST['user_id']);

    if ($user_list->in_list($figure_id)) {
        $user_list->remove($figure_id);
    } else {
        $user_list->add($figure_id);
    }
}
