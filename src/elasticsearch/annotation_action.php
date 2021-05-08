<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {

    session_start();

    include "../../src/mysql_login.php";

    $segmented_correctly = $subfigures_correct = $object_correct
    = $aspect_correct = 'TRUE';

    $num_segmented = $subfigure_labels = $object_label
    = $aspect_label = "NULL";

    $figure = $_POST['submit'];

    if (isset($_POST['segmented-correctly'])) {
        if ($_POST['segmented-correctly'] == 1) {
            $segmented_correctly = "1";
        }

        if ($_POST['segmented-correctly'] == -1) {
            $segmented_correctly = "0";
        }
    }

    if (isset($_POST['subfigures-labeled-correctly'])) {
        if ($_POST['subfigures-labeled-correctly'] == 1) {
            $subfigures_correct = "1";
        }

        if ($_POST['subfigures-labeled-correctly'] == -1) {
            $subfigures_correct = "0";
        }
    }

    if (isset($_POST['objects-labeled-correctly'])) {
        if ($_POST['objects-labeled-correctly'] == 1) {
            $object_correct = "1";
        }

        if ($_POST['objects-labeled-correctly'] == -1) {
            $object_correct = "0";
        }
    }

    if (isset($_POST['aspects-labeled-correctly'])) {
        if ($_POST['aspects-labeled-correctly'] == 1) {
            $aspect_correct = "1";
        }

        if ($_POST['aspects-labeled-correctly'] == -1) {
            $aspect_correct = "0";
        }
    }

    if (isset($_POST['num-segmented'])) {
        $num_segmented = $_POST['num-segmented'];
    }

    if (isset($_POST['label-subfigures'])) {
        $subfigure_labels = $_POST['label-subfigures'];
    }

    if (isset($_POST['label-objects'])) {
        $object_label = $_POST['label-objects'];
    }

    if (isset($_POST['label-aspects'])) {
        $aspect_label = $_POST['label-aspects'];
    }

    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO annotations (user_id, figure, segmented_correctly, "
    . "num_segments, subfigures_correct, subfigure_labels, object_correct, "
    . "object_label, aspect_correct, aspect_label) VALUES ('$user_id', "
    . "'$figure', '$segmented_correctly', '$num_segmented', '$subfigures_correct', "
    . "'$subfigure_labels', '$object_correct', '$object_label', "
    . "'$aspect_correct', '$aspect_label');";

    $url = $_POST['url'];

    if ($connection->query($sql)) {
        header("Location: $url");
    } else {
        echo $connection->error;
    }
}
