<?php

require '../../vendor/autoload.php';
include '../../constants.php';

$client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

if (isset($_POST['text'])) {

    $text = $_POST['text'];

    $query = $client->search([
        'index' => 'figures',
        'size' => 10,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['description' => $text]],
                        ['match' => ['object' => $text]],
                        ['match' => ['aspect' => $text]],
                        ['match' => ['figid' => $text]],
                        ['match' => ['origreftext' => $text]],
                        ['match' => ['patentID' => $text]],
                    ]
                ]
            ]
        ]
    ]);

    $results = [];

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }

    $suggestions = [];

    foreach($results as $r) {
        array_push($suggestions, $r['_source']['description']);
    }

    print json_encode($suggestions);
}
