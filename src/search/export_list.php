<?php

require '../../vendor/autoload.php';
include '../../src/user_list.php';
include '../../src/mysql_login.php';
require_once '../../src/dissertation.php';

if (isset($_POST['export'])) {

    $json_of_items = [];

    $user_list = new UserList();

    $user_list->set_id($_POST['export']);

    $query = "SELECT * FROM user_list_items WHERE list='" . $user_list->get_id() . "';";

    $results = $connection->query($query);

    $entry = 0;

    $list_name = $_POST['list-name'];

    while ($row = $results->fetch_assoc()) {

        include '../../constants.php';

        $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

        $dissertation = new Dissertation();

        $dissertation->set_id($row['dissertation_id']);

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

        $dissertation_json = [];

        // Set variables with keys in figure array.
        $dissertation_json['title'] = $dissertation->get_title();
        $dissertation_json['author'] = $dissertation->get_author();
        $dissertation_json['abstract'] = $dissertation->get_abstract();
        $dissertation_json['description'] = $dissertation->get_publisher();
        $dissertation_json['aspect'] = $dissertation->get_date();
        $dissertation_json['object'] = $dissertation->get_url();

        // Push array of figure attributes to array of list items.
        array_push($json_of_items, $dissertation_json);
    }

    // Encode the array of list items into a JSON object.
    $json_of_items = json_encode($json_of_items, JSON_UNESCAPED_SLASHES);

    if (isset($_POST['export'])) {

        // If the export button is pressed, user will download the JSON file.
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename=' . $list_name . '.json');
        print_r($json_of_items);
    }
}
