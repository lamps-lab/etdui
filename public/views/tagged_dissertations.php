<?php

include '../../src/mysql_login.php';
require '../../vendor/autoload.php';
require_once '../../src/dissertation.php';
include 'header.php';

$tag = "";

if (!isset($_GET['tag'])) {
    header('Location: index.php');
} else {

    $query = "SELECT * FROM tags WHERE name='"
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

        while ($row = $results->fetch_assoc()) {
            include '../../constants.php';
    
    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

            $dissertation = new Dissertation();

            $dissertation->set_id($row['dissertation']);

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

            $dissertation->result($entry);

            $entry += 1;
        }
        ?>
    </div>
    <script src="../../public/js/searchFunctions.js"></script>
</body>