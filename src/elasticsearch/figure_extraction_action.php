<?php

ini_set( 'post_max_size' , '64M' );
ini_set( 'memory_limit' , '128M' );
ini_set( 'upload_max_file_size' , '10M' );

include '../../constants.php';


if (isset($_FILES['file'])) {
    $file_tmp = $_FILES['file']['tmp_name'];

    $command = "/usr/bin/python3 " . FIGURE_EXTRACTION_SERVICE_PATH . "test/rundetection.py " . $file_tmp;

    shell_exec($command);
}