<?php

include '../auth/redirect.php';
include '../auth/is_verified.php';

require '../../vendor/autoload.php';

include '../../constants.php';

$client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

$title = $url = $author = $abstract = $publisher = $subject
    = $department = $degree = $date = '';

$results = [];


// Set variables.

if (isset($_POST['title'])) {
    $title = $_POST['title'];
}

if (isset($_POST['url'])) {
    $url = $_POST['url'];
}

if (isset($_POST['author'])) {
    $author = $_POST['author'];
}

if (isset($_POST['abstract'])) {
    $abstract = $_POST['abstract'];
}

if (isset($_POST['publisher'])) {
    $publisher = $_POST['publisher'];
}

if (isset($_POST['subject'])) {
    $subject = $_POST['subject'];
}

if (isset($_POST['department'])) {
    $department = $_POST['department'];
}

if (isset($_POST['degree'])) {
    $degree = $_POST['degree'];
}

if (isset($_POST['date'])) {
    $date = $_POST['date'];
    if (!DateTime::createFromFormat('Y-m-d', $date)) {
        echo "<script> alert('Date is not in the correct format.');
            window.location = '../../public/views/index.php'; </script>";
    }
}

// Create array for indexing dissertation entry.
$params = [
    'index' => 'dissertations',
    'body' => [
        'title' => $title,
        'identifier_sourceurl' => $url,
        'contributor_author' => $author,
        'description_abstract' => $abstract,
        'publisher' => $publisher,
        'subject' => $subject,
        'contributor_department' => $department,
        'degree_name' => $degree,
        'date_issued' => $date
    ]
];

$response = $client->index($params);

$params_2 = [
    'index' => 'dissertations',
    'id' => $response['_id']
];

$result = $client->get($params_2);

include '../../public/views/header.php';
?>

<body>
    <?php
    include '../../public/views/menu.php';
    include '../../public/views/search_bar.php';
    include '../../public/views/advanced_search.php';

    include '../../src/dissertation.php';

    $dissertation = new Dissertation();

    // Set the abstract.
    $dissertation->set_id($response['_id']);
    $dissertation->set_abstract($result['_source']['description_abstract']);
    $dissertation->set_url($result['_source']['identifier_sourceurl']);
    $dissertation->set_title($result['_source']['title']);
    $dissertation->set_author($result['_source']['contributor_author']);
    $dissertation->set_publisher(['_source']['publisher']);
    $dissertation->set_date($result['_source']['date_issued']);

    $dissertation->result(0);

    ?>

<script src="../../public/js/searchFunctions.js"></script>
</body>

</html>