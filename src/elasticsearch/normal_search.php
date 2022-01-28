<?php

require '../../vendor/autoload.php';

function text_query($client, $search)
{
    $query = $client->search([
        'index' => 'dissertations',
        'size' => 10000,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['contributor_author' => $search]],
                        ['match' => ['contributor_committeechair' => $search]],
                        ['match' => ['contributor_committeemember' => $search]],
                        ['match' => ['contributor_department' => $search]],
                        ['match' => ['degree_grantor' => $search]],
                        ['match' => ['degree_level' => $search]],
                        ['match' => ['degree_name' => $search]],
                        ['match' => ['description_abstract' => $search]],
                        ['match' => ['description_degree' => $search]],
                        ['match' => ['description_provenance' => $search]],
                        ['match' => ['format_medium' => $search]],
                        ['match' => ['handle' => $search]],
                        ['match' => ['identifier_other' => $search]],
                        ['match' => ['identifier_sourceurl' => $search]],
                        ['match' => ['identifier_uri' => $search]],
                        ['match' => ['publisher' => $search]],
                        ['match' => ['relation_haspart' => $search]],
                        ['match' => ['rights' => $search]],
                        ['match' => ['subject' => $search]],
                        ['match' => ['title' => $search]],
                        ['match' => ['type' => $search]],
                    ]
                ]
            ]
        ]
    ]);

    return $query;
}

function date_query($client, $search)
{
    $query = $client->search([
        'index' => 'dissertations',
        'size' => 10000,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['date_accessioned' => $search]],
                        ['match' => ['date_adate' => $search]],
                        ['match' => ['date_available' => $search]],
                        ['match' => ['date_issued' => $search]],
                        ['match' => ['date_rdate' => $search]],
                        ['match' => ['date_sdate' => $search]],
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

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    
    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

    $query = [];

    if (!DateTime::createFromFormat('Y-m-d', $search)) {
        // If search is not in date format, search all text queries.
        $query = text_query($client, $search);
    } else {
        // If the string is a date, search for date attributes.
        $query = date_query($client, $search);
    }

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }

    return $results;
}
