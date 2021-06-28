<?php

if (isset($_POST['handle'])) {

    require_once '../../src/user_list.php';

    $figure_id = $_POST['dissertation_id'];

    $user_list = new UserList();
    $user_list->set_id($_POST['list_id']);
    $user_list->set_user($_POST['user_id']);

    if ($user_list->in_list($figure_id)) {
        // If the list item is already in the list, clicking the button will
        // remove the item from the list.
        $user_list->remove($figure_id);
    } else {
        // If the item is not in the list, clicking the button will add the
        // item to the list.
        $user_list->add($figure_id);
    }
}
