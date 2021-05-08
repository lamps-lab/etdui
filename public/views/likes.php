<?php
require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
require_once '../../src/figure.php';
?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">
        <br>
        <h1> Likes </h1><br>
        <?php

        $user_id = $_SESSION['user_id'];

        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_figure_likes WHERE user='"
            . $user_id . "';";

        $results = $connection->query($query);


        $entry = 0;

        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

            $figure = new Figure();

            $figure->set_id($row['figure_id']);

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
        <script src="../../public/js/searchFunctions.js"></script>

    </div>
</body>

</html>