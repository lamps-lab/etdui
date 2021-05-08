<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'normal_search.php';
include 'advanced_search_action.php';

$results = [];
$search_v = '';

$search = "";

$multiple = $patent_id = $text_reference = $figure_id = $description =
    $aspect = $object = $caption = '';

$multiple = $patent_id_v = $text_reference_v = $figure_id_v = $description_v =
    $aspect_v = $object_v = '';

// If the normal search button was clicked, perform the 
// normal search.
if (isset($_GET['search'])) {

    // Set the query variable with the inputted search data.
    $search = $_GET['search'];

    // Filter query from possible XSS attacks.
    $search = filter_var($search, FILTER_SANITIZE_STRING);

    $search_v = $search;

    $temp_array = array($search);
    $replace = array('<mark class="highlight">' . $search . '</mark>');

    // Retrieve results from the normal search function.
    $results = normal_search($search);
}

// If the advanced search button was clicked, perform the
// advanced search.
if (isset($_GET['advanced_search'])) {

    $temp = '';

    $temp_array = [];
    $replace = [];

    // Set all of the variables and sanitize the strings.
    if (isset($_GET['patent-id'])) {

        $patent_id = $_GET['patent-id'];
        $patent_id = filter_var($patent_id, FILTER_SANITIZE_STRING);
        $patent_id_v = $patent_id;

        if (!empty($patent_id)) {
            array_push($temp_array, $patent_id);
            array_push($replace, '<mark class="highlight"> ' . $patent_id . ' </mark>');
        }
    }

    if (isset($_GET['text-reference'])) {
        $text_reference = $_GET['text-reference'];
        $text_reference = filter_var($text_reference, FILTER_SANITIZE_STRING);
        $text_reference_v = $text_reference;

        if (!empty($text_reference)) {
            array_push($temp_array, $text_reference);
            array_push($replace, '<mark class="highlight">' . $text_reference . '</mark>');
        }
    }

    if (isset($_GET['figure-id'])) {
        $figure_id = $_GET['figure-id'];
        $figure_id = filter_var($figure_id, FILTER_SANITIZE_STRING);
        $figure_id_v =  $figure_id;

        if (!empty($figure_id)) {
            array_push($temp_array, $figure_id);
            array_push($replace, '<mark class="highlight">' . $figure_id . '</mark>');
        }
    }

    if (isset($_GET['description'])) {
        $description = $_GET['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $description_v =  $description;

        if (!empty($description)) {
            array_push($temp_array, $description);
            array_push($replace, '<mark class="highlight">' . $description . '</mark>');
        }
    }

    if (isset($_GET['aspect'])) {
        $aspect = $_GET['aspect'];
        $aspect = filter_var($aspect, FILTER_SANITIZE_STRING);
        $aspect_v = $aspect;

        if (!empty($aspect)) {
            array_push($temp_array, $aspect);
            array_push($replace, '<mark class="highlight">' . $aspect . '</mark>');
        }
    }

    if (isset($_GET['object'])) {
        $object = $_GET['object'];
        $object = filter_var($object, FILTER_SANITIZE_STRING);
        $object_v = $object;

        if (!empty($object)) {
            array_push($temp_array, $object);
            array_push($replace, '<mark class="highlight">' . $object . '</mark>');
        }
    }

    if (isset($_GET['multiple'])) {
        $multiple = 1;
    } else {
        $multiple = 0;
    }

    if (isset($_GET['caption'])) {
        $caption = 1;
    } else {
        $caption = 0;
    }

    // Retrieve the boolean for if all the inputs are empty.
    $all_empty = no_inputs(
        $patent_id,
        $text_reference,
        $figure_id,
        $description,
        $aspect,
        $object
    );

    if ($all_empty) {
        // If all of the inputs are empty, redirect the user and warn them.
        echo "<script> alert('At least one field must be filled in.');
            window.location = 'results.php'; </script>";
    }


    $results = advanced_search(
        $patent_id,
        $text_reference,
        $figure_id,
        $description,
        $aspect,
        $object,
        $multiple,
        $caption
    );
}

include '../../public/views/header.php';
?>

<body>
    <?php
    session_start();
    include '../../public/views/menu.php';
    include '../../public/views/search_bar.php';
    require_once '../figure.php';

    $total_results = count($results);
    $results_per_page = 9;
    $total_pages = ceil($total_results / $results_per_page);

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $offset = ($page - 1) * $results_per_page;

    $results = array_slice($results, $offset, $results_per_page);
    // Print out the number of returned search results.
    echo '<p class="num-results"> ' . $total_results . ' search results for ' . $search .
        $patent_id_v . ' ' . $text_reference_v . ' ' . $description_v . ' ' . $figure_id_v .
        $aspect_v . ' ' . $object_v . ' ' . $degree_v . ' ' .
        $beg_date_v . ' ' . $end_date_v . '</p>';

    $search_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    echo '<p id="url" hidden>' . $search_url . '</p>';

    include 'search_saved.php';

    $entry = 1;

    include '../../public/views/faceted_search.php';
    echo '<div class="results-container">';
    foreach ($results as $r) {

        // Set the figure data variables.
        $patent_id = $r['_source']['patentID'];
        $text_reference = $r['_source']['origreftext'];
        $figure_id = $r['_source']['figid'];
        $description = $r['_source']['description'];
        $aspect = $r['_source']['aspect'];
        $object = $r['_source']['object'];
        $subfig = $r['_source']['subfig'];

        $figure = new Figure();

        $figure->set_id($r['_id']);
        
        // Replace strings with highlighted text.
        $figure->set_patent_id($patent_id);
        $figure->set_text_reference(str_ireplace($temp_array, $replace, $text_reference));
        $figure->set_figure_id($figure_id);
        $figure->set_subfig($subfig);
        $figure->set_description(str_ireplace($temp_array, $replace, $description));
        $figure->set_aspect(str_ireplace($temp_array, $replace, $aspect));
        $figure->set_object(str_ireplace($temp_array, $replace, $object));

        echo $figure->display_result($entry) . '&nbsp;';

        $entry += 1;
    }

    echo '</div>';

    $current_url = $_SERVER["REQUEST_URI"];

    $previous_page = $page - 1;
    $first_page = 1;
    $last_page = $total_pages;
    $max_page_links = $page + 10;

    echo '<div class="pagination">';

    $counter = 0;

    if ($total_pages > 0) {
        if ($page > 2) {
            echo '<a href="' . $current_url . '&page=' . $first_page . '"> << </a>';
        }

        if ($page != 1) {
            echo '<a href="' . $current_url . '&page=' . $previous_page . '"> < </a>';
        }

        for ($page; $page <= $max_page_links; $page++) {
            if ($counter == 0) {
                echo '<a href="' . $current_url . '&page=' . $page . '" style="background-color: #00BFFF;">' . $page . '</a>';
                $counter++;
            } else {
                echo '<a href="' . $current_url . '&page=' . $page . '">' . $page . '</a>';
            }
            if ($page == $total_pages) {
                break;
            }
        }
        if ($page != $total_pages) {
            echo '<a href="' . $current_url . '&page=' . $total_pages . '"> >> </a>';
        }

        echo '</div>';
    }
    ?>

    <script src="../../public/js/searchFunctions.js"></script>
</body>

</html>