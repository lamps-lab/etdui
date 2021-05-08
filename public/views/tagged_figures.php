<?php

include '../../src/mysql_login.php';
require '../../vendor/autoload.php';
require_once '../../src/figure.php';
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
        <?php
        $entry = 0;

        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

            $figure = new Figure();

            $figure->set_id($row['figure']);

            $params = [
                'index' => 'figures',
                'id' => $figure->get_id()
            ];

            $response = $client->get($params);

            $figure->set_patent_id($response['_source']['patentID']);
            $figure->set_description($response['_source']['description']);
            $figure->set_figure_id($response['_source']['figid']);
            $figure->set_object($response['_source']['object']);
            $figure->set_aspect($response['_source']['aspect']);
            $figure->set_text_reference($response['_source']['origreftext']);

            $figure->display_result($entry);

            $entry += 1;
        }
        ?>
    </div>
</body>