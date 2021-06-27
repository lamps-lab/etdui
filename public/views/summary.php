<?php

include 'header.php';

// include '../../src/auth/redirect.php';
// include '../../src/auth/is_verified.php';
require '../../vendor/autoload.php';
require_once '../../src/dissertation.php';

if (isset($_GET['dissertation-id'])) {

    $dissertation = new Dissertation();

    // Set the dissertation ID.
    $dissertation->set_id($_GET['dissertation-id']);

    $client = Elasticsearch\ClientBuilder::create()->build();

    $params = [
        'index' => 'dissertations',
        'id' => $dissertation->get_id()
    ];

    $response = $client->get($params);

    $dissertation->set_title($response['_source']['title']);
    $dissertation->set_author($response['_source']['contributor_author']);
    $dissertation->set_abstract($response['_source']['description_abstract']);
    $dissertation->set_publisher($response['_source']['publisher']);
    $dissertation->set_date($response['_source']['date_issued']);
    $dissertation->set_url($response['_source']['identifier_sourceurl']);

    echo "<body>";
    include '../../public/views/menu.php';
    echo "<br><br><br>";
    $dissertation->summary();
    echo '<script src="../../public/js/searchFunctions.js"></script>';
    echo "</body>
    </html>";
} else {

    // If no dissertation is clicked, redirect the user to the main page.
    header('Location: index.php');
}
