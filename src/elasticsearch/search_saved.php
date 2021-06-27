<?php

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

require_once '../../src/search_history.php';

$search_history = new SearchHistory();

$search_history->set_user($_SESSION['user_id']);
$search_history->set_title($title_v);
$search_history->set_author($author_v);
$search_history->set_publisher($publisher_v);
$search_history->set_abstract($abstract_v);
$search_history->set_subject($subject_v);
$search_history->set_department($department_v);
$search_history->set_degree($degree_v);
$search_history->set_beg_date($beg_date_v);
$search_history->set_end_date($end_date_v);
$search_history->set_normal_search($search);
$search_history->set_url($search_url);

if (isset($_SESSION['user_id'])) {
    $class = "save-history";

    if ($search_history->is_saved()) {
        $class = "saved-history";
    }
    echo '<button class=' . $class . ' id="save_history" type="button" onClick="handleSearchHistory()"></button><br><br><br><br><br>';
}
