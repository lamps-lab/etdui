<?php

require '../../vendor/autoload.php';

function no_inputs($patent_id, $text_reference, $figure_id, $description, $aspect, $object)
{
    $all_empty = true;

    // If any of the inputs are filled in, set the all empty boolean
    // to false.

    if (!empty($patent_id)) {
        $all_empty = false;
    }

    if (!empty($text_reference)) {
        $all_empty = false;
    }

    if (!empty($figure_id)) {
        $all_empty = false;
    }

    if (!empty($description)) {
        $all_empty = false;
    }

    if (!empty($aspect)) {
        $all_empty = false;
    }

    if (!empty($object)) {
        $all_empty = false;
    }

    return $all_empty;
}

function query_builder($query_array, $field, $input)
{

    array_push($query_array['body']['query']['bool']['must'], ['match' => [$field => $input]]);

    return $query_array;
}

function advanced_search($patent_id, $text_reference, $figure_id, $description, $aspect, $object, $multiple, $caption)
{
    include '../../constants.php';
    $client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

    // Initialize a string builder for the advanced search query.
    $query_array = [
        'index' => 'figures',
        'size' => 5000,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ]
        ]
    ];


    if (!empty($patent_id)) {
        $query_array = query_builder($query_array, 'patentID', $patent_id);
    }

    if (!empty($text_reference)) {
        $query_array = query_builder($query_array, 'origreftext', $text_reference);
    }

    if (!empty($figure_id)) {
        $query_array = query_builder($query_array, 'figid', $figure_id);
    }

    if (!empty($description)) {
        $query_array = query_builder($query_array, 'description', $description);
    }

    if (!empty($aspect)) {
        $query_array = query_builder($query_array, 'aspect', $aspect);
    }

    if (!empty($object)) {
        $query_array = query_builder($query_array, 'object', $object);
    }

    if (!empty($multiple)) {
        $query_array = query_builder($query_array, 'is_multiple', $multiple);
    }

    if (!empty($caption)) {
        $query_array = query_builder($query_array, 'is_caption', $caption);
    }

    $query = $client->search($query_array);


    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }

    return $results;
}
