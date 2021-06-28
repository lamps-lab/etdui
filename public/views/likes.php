<?php
require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
require_once '../../src/dissertation.php';
?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">
        <br>
        <h1> Likes </h1><br>
        <?php

        $user_id = $_SESSION['user_id'];

        include '../../src/mysql_login.php';

        // Query all of the dissertations a user has liked.
        $query = "SELECT * FROM user_likes WHERE user='"
            . $user_id . "';";

        $results = $connection->query($query);

        // Initialize the entry number.
        $entry = 0;

        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->build();

            $dissertation = new Dissertation();

            $dissertation->set_id($row['dissertation_id']);

            // Return the Elasticsearch entry with the matching ID.
            $params = [
                'index' => 'dissertations',
                'id' => $dissertation->get_id()
            ];
            $response = $client->get($params);

            // Set all of the dissertation values.
            $dissertation->set_title($response['_source']['title']);
            $dissertation->set_author($response['_source']['contributor_author']);
            $dissertation->set_publisher($response['_source']['publisher']);
            $dissertation->set_date($response['_source']['date_issued']);
            $dissertation->set_url($response['_source']['identifier_sourceurl']);
            $abstract = $response['_source']['description_abstract'];

            // $preview = $dissertation->shorten_abstract($abstract);
            $dissertation->set_abstract($preview);

            // Call the function to show the dissertation result.
            $dissertation->result($entry);

            // Increment the entry number.
            $entry += 1;
        }
        ?>
        <script src="../../public/js/searchFunctions.js"></script>

    </div>
</body>

</html>