<?php

require_once '../../src/search_history.php';

if (isset($_POST['handled'])) {

    session_start();

    $search_history = new SearchHistory();

    $search_history->set_user($_SESSION['user_id']);
    $search_history->set_patent_id($_POST['patent-id']);
    $search_history->set_text_reference($_POST['text-reference']);
    $search_history->set_figure_id($_POST['figure-id']);
    $search_history->set_description($_POST['description']);
    $search_history->set_aspect($_POST['aspect']);
    $search_history->set_object($_POST['object']);
    $search_history->set_normal_search($_POST['normal_search']);
    $search_history->set_date_searched(date('Y-m-d H:i:s'));
    $search_history->set_url($_POST['url']);

    if ($search_history->is_saved()) {
        $search_history->clear_search();
        echo 'cleared';
    } else {
        $search_history->save_search();
    }
}

if (isset($_POST['clear'])) {
    $search_history = new SearchHistory();

    $search_history->clear_all();
}
