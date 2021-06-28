<?php


require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
require_once '../../src/dissertation.php';
include '../../src/mysql_login.php';


if (!isset($_GET['list-id'])) {
    echo "<script>window.location = '../../public/views/index.php';</script>";
} else {
    $list_name = $_GET['list-name'];
    $list_id = $_GET['list-id'];
}

include 'header.php';

?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">
        <br>
        <h1> <?php echo $list_name; ?> </h1><br>

        <form action="../../src/elasticsearch/export_list.php" method="POST">
        <input type="hidden" name="list-name" value= <?php echo $list_name ?> ></input>
        <button class="search" type="submit" name="export" value= <?php echo $_GET['list-id'] ?> style="margin-right: 10px;">Export to JSON</button>
        </form>

        <br><br><br><br><br><br>
        <?php

        $user_id = $_SESSION['user_id'];

        // Query the list items that match the current list ID.
        $query = "SELECT * FROM user_dissertation_list_items WHERE list='" . $list_id . "';";

        $results = $connection->query($query);

        $entry = 0;

        // Iterate through all of the list items.
        while ($row = $results->fetch_assoc()) {
            $client = Elasticsearch\ClientBuilder::create()->build();

            $dissertation = new Dissertation();

            $dissertation->set_id($row['dissertation_id']);

            // Select the dissertation metadata from Elasticsearch by the ID.
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

            $dissertation->result($entry);

            $entry += 1;
        }

        ?>
        <script src="../../public/js/searchFunctions.js"></script>
</body>

</html>