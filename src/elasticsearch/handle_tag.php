<?php

session_start();

require_once '../../src/tag.php';

$tag = new Tag();

if ($_POST['handle'] == "added") {

    $tag->set_name($_POST['tag']);
    $tag->set_user($_SESSION['user_id']);
    $tag->set_figure_id($_POST['figure_id']);

    if (!$tag->has_tag()) {
        // If the tag is not already added, add it to the figure.
        $tag->add_tag();

    } else {
        echo 1;
    }
}

if ($_POST['handle'] == "removed") {
    $tag->set_id($_POST['tag_id']);
    $tag->remove_tag();
}
