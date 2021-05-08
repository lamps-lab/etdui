<?php

include 'header.php';

include '../../constants.php';
require '../../vendor/autoload.php';
require_once '../../src/figure.php';

if (isset($_GET['id'])) {
    $previous_url = "";

    if (isset($_GET['previous-url'])) {
        $previous_url = $_GET['previous-url'];
    }

    $figure = new Figure();

    // Set the dissertation ID.
    $figure->set_id($_GET['id']);

    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

    $params = [
        'index' => 'figures',
        'id' => $figure->get_id()
    ];

    $response = $client->get($params);

    $figure->set_patent_id($response['_source']['patentID']);
    $figure->set_text_reference($response['_source']['origreftext']);
    $figure->set_figure_id($response['_source']['figid']);
    $figure->set_description($response['_source']['description']);
    $figure->set_aspect($response['_source']['aspect']);
    $figure->set_object($response['_source']['object']);
    $figure->set_date($response['_source']['patent_date']);

    echo "<body>";
    include '../../public/views/menu.php';
    echo "<br><br><br>";
    echo "<button type='button' class='download' style='margin-left: 50px;' name='back-button' id='back-button' onclick='backToResults(\"$previous_url\")'>Back To Results</button><br><br>";
    $figure->summary();
    echo "</body>
    <script src='../../public/js/searchFunctions.js'></script>
    </html>";
} else {

    // If no dissertation is clicked, redirect the user to the main page.
    header('Location: index.php');
}
