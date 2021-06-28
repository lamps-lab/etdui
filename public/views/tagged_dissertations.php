<?php

include '../../src/mysql_login.php';
require '../../vendor/autoload.php';
require_once '../../src/dissertation.php';
include 'header.php';

$tag = "";

if (!isset($_GET['tag'])) {
    header('Location: index.php');
} else {

    // If the user clicks on a dissertation tag, query all the dissertations with that tag name.
    $query = "SELECT * FROM dissertation_tags WHERE name='"
        . $_GET['tag'] . "';";

    $results = $connection->query($query);
}

?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">
    <br>
        <h1><?php echo $_GET['tag'] ?></h1><br>
        <?php
        $entry = 0;

        // Iterate through all of the dissertations with the selected tag.
        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->build();

            $dissertation = new Dissertation();

            $dissertation->set_id($row['dissertation']);

            $params = [
                'index' => 'dissertations',
                'id' => $dissertation->get_id()
            ];
        
            $response = $client->get($params);
        
            // Set all of the dissertation values.
            $dissertation->set_title($response['_source']['title']);
            $dissertation->set_author($response['_source']['contributor_author']);
            $dissertation->set_abstract($response['_source']['description_abstract']);
            $dissertation->set_publisher($response['_source']['publisher']);
            $dissertation->set_date($response['_source']['date_issued']);
            $dissertation->set_url($response['_source']['identifier_sourceurl']);

            // Display the result of the current dissertation on the page.
            $dissertation->result($entry);

            $entry += 1;
        }
        ?>
    </div>
    <script src="../../public/js/searchFunctions.js"></script>
</body>