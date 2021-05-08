<?php

require '../../vendor/autoload.php';

function text_query($client, $search)
{
    $query = $client->search([
        'index' => 'figures',
        'size' => 10000,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['description' => $search]],
                        ['match' => ['figid' => $search]],
                        ['match' => ['object' => $search]],
                        ['match' => ['origreftext' => $search]],
                        ['match' => ['patentID' => $search]],
                        ['match' => ['pid' => $search]],
                        ['match' => ['subfig' => $search]],
                        ['match' => ['aspect' => $search]]
                    ]
                ]
            ]
        ]
    ]);

    return $query;
}

function normal_search($search)
{
    include '../../constants.php';
    
    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

    // If search is not in date format, search all text queries.
    $query = text_query($client, $search);

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }

    return $results;
}
