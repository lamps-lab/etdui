<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../constants.php';
include '../../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

// Set up the paramaters for the authors query.
$params = [
    'index' => 'dissertations',
        "body" =>[
            'size' => 0,
            'aggs' => [
                "authors" => [
                    "terms" => [
                        "field" => "contributor_author.keyword",
                        "size" => 500
                    ]
                ]
            ]
        ]
];

// Search for all of the authors in the Elasticsearch dissertations document.
$query = $client->search($params);

$results = [];

if ($query['hits']['total'] >= 1) {
    $results = $query['aggregations']['authors']['buckets'];
}

echo json_encode($results);