<?php

require_once '../../src/search_history.php';

$search_history = new SearchHistory();

$search_history->set_user($_SESSION['user_id']);
$search_history->set_patent_id($patent_id_v);
$search_history->set_text_reference($text_reference_v);
$search_history->set_figure_id($figure_id_v);
$search_history->set_description($description_v);
$search_history->set_aspect($aspect_v);
$search_history->set_object($object_v);
$search_history->set_normal_search($search);
$search_history->set_url($search_url);

if (isset($_SESSION['user_id'])) {
    $class = "save-history";

    if ($search_history->is_saved()) {
        $class = "saved-history";
    }
    echo '<button class=' . $class . ' id="save_history" type="button" onClick="handleSearchHistory()"></button><br><br><br><br><br>';
}
