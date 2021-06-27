<?php

require '../../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

if (isset($_POST['text'])) {

    $text = $_POST['text'];

    $query = $client->search([
        'index' => 'dissertations',
        'size' => 10,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['title' => $text]],
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
        array_push($suggestions, $r['_source']['title']);
    }

    print json_encode($suggestions);
}
