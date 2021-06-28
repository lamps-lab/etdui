<?php

require '../../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

if (isset($_POST['text'])) {

    $text = $_POST['text'];

    // Return an Elasticsearch query based on what has been typed.
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

    // Push each of the results in the suggestions array.
    foreach($results as $r) {
        array_push($suggestions, $r['_source']['title']);
    }

    // Encode the suggestions into a JSON array.
    print json_encode($suggestions);
}
