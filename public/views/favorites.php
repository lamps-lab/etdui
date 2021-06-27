<?php
include 'header.php';
require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
require_once '../../src/dissertation.php';
include '../../src/mysql_login.php';
?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">
        <br>
        <h1> Favorites </h1><br>
        <?php

        $user_id = $_SESSION['user_id'];

        $query = "SELECT * FROM favorites WHERE user='"
            . $user_id . "';";

        $results = $connection->query($query);

        $entry = 0;

        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->build();

            $dissertation = new Dissertation();

            $dissertation->set_id($row['dissertation_id']);

            $params = [
                'index' => 'dissertations',
                'id' => $dissertation->get_id()
            ];

            $response = $client->get($params);

            $dissertation->set_title($response['_source']['title']);
            $dissertation->set_author($response['_source']['contributor_author']);
            $dissertation->set_publisher($response['_source']['publisher']);
            $dissertation->set_date($response['_source']['date_issued']);
            $dissertation->set_url($response['_source']['identifier_sourceurl']);
            $abstract = $response['_source']['description_abstract'];

            $dissertation->set_abstract($abstract);

            $dissertation->result($entry);

            $entry += 1;
        }
        ?>
        <script src="../../public/js/searchFunctions.js"></script>
</body>

</html>