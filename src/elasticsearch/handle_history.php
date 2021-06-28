<?php

require_once '../../src/search_history.php';

if (isset($_POST['handled'])) {

    session_start();

    $search_history = new SearchHistory();

    // Set the search history values.
    $search_history->set_user($_SESSION['user_id']);
    $search_history->set_title($_POST['title']);
    $search_history->set_author($_POST['author']);
    $search_history->set_publisher($_POST['publisher']);
    $search_history->set_abstract($_POST['abstract']);
    $search_history->set_subject($_POST['subject']);
    $search_history->set_department($_POST['department']);
    $search_history->set_degree($_POST['degree']);
    $search_history->set_beg_date($_POST['beg_date']);
    $search_history->set_end_date($_POST['end_date']);
    $search_history->set_normal_search($_POST['normal_search']);
    $search_history->set_date_searched(date('Y-m-d H:i:s'));
    $search_history->set_url($_POST['url']);

    if ($search_history->is_saved()) {
        // If the search history is saved, clicking the button will clear the search history.
        $search_history->clear_search();
        echo 'cleared';
    } else {
        // If the search history is not saved, clicking the button will save the search history.
        $search_history->save_search();
    }
}

if (isset($_POST['clear'])) {

    // If the clear search history button is clicked, clear all search history.
    $search_history = new SearchHistory();

    $search_history->clear_all();
}
