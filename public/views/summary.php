<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'header.php';

// include '../../src/auth/redirect.php';
// include '../../src/auth/is_verified.php';
require '../../vendor/autoload.php';
require_once '../../src/dissertation.php';
require '../../src/user.php';
include '../../src/mysql_login.php';
include '../../constants.php';


$previous_url = "";

if (isset($_GET['dissertation-id'])) {

    if (isset($_GET['previous-url'])) {
        $previous_url = $_GET['previous-url'];
    }

    // echo $previous_url;

    $dissertation = new Dissertation();

    // Set the dissertation ID.
    $dissertation->set_id($_GET['dissertation-id']);

    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

    $params = [
        'index' => 'dissertations',
        'id' => $dissertation->get_id()
    ];

    $response = $client->get($params);

    $dissertation->set_title($response['_source']['title']);
    $dissertation->set_author($response['_source']['contributor_author']);
    $dissertation->set_abstract($response['_source']['description_abstract']);
    $dissertation->set_publisher($response['_source']['publisher']);
    $dissertation->set_year($response['_source']['date_issued']);
    $dissertation->set_url($response['_source']['identifier_sourceurl']);

    $user = new User();
    $user->query_by_id($_SESSION['user_id']);

    echo "<body>";
    include '../../public/views/menu.php';
    echo "<br><br><br>";

    echo "<button type='button' class='download' name='back-button' id='back-button' onclick='backToResults(\"$previous_url\")'>Back To Results</button><br><br>";

    $dissertation->summary();
    echo '<script src="../../public/js/searchFunctions.js"></script>';
    echo "</body>
    </html>";
} else {

    // If no dissertation is clicked, redirect the user to the main page.
    header('Location: index.php');
}
