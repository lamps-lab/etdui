<?php


require '../../vendor/autoload.php';
include '../../src/user_list.php';
include '../../src/mysql_login.php';
require_once '../../src/figure.php';

if (isset($_POST['export'])) {

    $json_of_items = [];

    $user_list = new UserList();

    $user_list->set_id($_POST['export']);

    $query = "SELECT * FROM user_list_items WHERE list='" . $user_list->get_id() . "';";

    $results = $connection->query($query);

    $entry = 0;

    $list_name = $_POST['list-name'];

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

        $figure_json = [];

        // Set variables with keys in figure array.
        $figure_json['patentID'] = $figure->get_patent_id();
        $figure_json['text_ref'] = $figure->get_text_reference();
        $figure_json['figureID'] = $figure->get_figure_id();
        $figure_json['description'] = $figure->get_description();
        $figure_json['aspect'] = $figure->get_aspect();
        $figure_json['object'] = $figure->get_object();
        $figure_json['pid'] = $response['_source']['pid'];
        $figure_json['subfig'] = $response['_source']['subfig'];
        $figure_json['is_caption'] = $response['_source']['is_caption'];
        $figure_json['is_multiple'] = $response['_source']['is_multiple'];

        // Push array of figure attributes to array of list items.
        array_push($json_of_items, $figure_json);
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
