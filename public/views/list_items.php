<?php


require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
require_once '../../src/figure.php';
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

        $query = "SELECT * FROM user_list_items WHERE list='" . $list_id . "';";

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
            $figure->set_text_reference($response['_source']['origreftext']);
            $figure->set_figure_id($response['_source']['figid']);
            $figure->set_description($response['_source']['description']);
            $figure->set_aspect($response['_source']['aspect']);
            $figure->set_object($response['_source']['object']);

            $figure->display_result($entry);

            $entry += 1;
        }

        ?>
        <script src="../../public/js/searchFunctions.js"></script>
</body>

</html>