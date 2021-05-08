<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include '../auth/redirect.php';
include '../auth/is_verified.php';

require '../../vendor/autoload.php';

include '../../constants.php';
    
$client = Elasticsearch\ClientBuilder::create()->setHosts(ELASTICSEARCH_HOST)->build();

$patent_id = $text_reference = $figure_id = $description =
    $aspect = $object = $pid = $subfig = $image_name = 
    $image_temp = '';

$multiple = 0;
$caption = 0;

$results = [];


// Set variables.

if (isset($_POST['patent-id'])) {
    $patent_id = $_POST['patent-id'];
}

if (isset($_POST['text-reference'])) {
    $url = $_POST['text-reference'];
}

if (isset($_POST['figure-id'])) {
    $figure_id = $_POST['figure-id'];
}

if (isset($_POST['aspect'])) {
    $aspect = $_POST['aspect'];
}

if (isset($_POST['object'])) {
    $object = $_POST['object'];
}

if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
}

if (isset($_POST['subfig'])) {
    $subfig = $_POST['subfig'];
}

if (isset($_POST['multiple'])) {
    $multiple = 1;
}

if (isset($_POST['caption'])) {
    $caption = 1;
}

if (isset($_FILES['img'])) {
    $image_temp = $_FILES['img']['tmp_name'];
}

// Create array for indexing figure entry.
$params = [
    'index' => 'figures',
    'body' => [
        'description' => $description,
        'figid' => $figure_id,
        'is_caption' => $caption,
        'description_abstract' => $abstract,
        'is_multiple' => $multiple,
        'object' => $object,
        'origreftext' => $text_reference,
        'patentID' => $patent_id,
        'aspect' => $aspect,
        'pid' => $pid
    ]
];

$response = $client->index($params);

$params_2 = [
    'index' => 'figures',
    'id' => $response['_id']
];

$result = $client->get($params_2);

include '../../public/views/header.php';
?>

<body>
    <?php
    include '../../public/views/menu.php';
    include '../../public/views/search_bar.php';
    include '../../src/figure.php';

    $figure = new Figure();

    $figure->set_patent_id($result['_source']['patentID']);
    $figure->set_text_reference($result['_source']['origreftext']);
    $figure->set_figure_id($result['_source']['figid']);
    $figure->set_description($result['_source']['description']);
    $figure->set_aspect($result['_source']['aspect']);
    $figure->set_object($result['_source']['object']);


    $image_name = FIGURES_PATH . $figure->get_patent_id() . "-D0000" . $figure->get_figure_id() . ".png";
    move_uploaded_file($image_temp, $image_name);

    echo "<body>";
    echo "<br><br><br>";
    $figure->summary();
    echo "</body>
    </html>";

    ?>

<script src="../../public/js/searchFunctions.js"></script>
</body>

</html>