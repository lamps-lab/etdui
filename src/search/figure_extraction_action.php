<?php

include '../../constants.php';


if (isset($_FILES['file'])) {
    $file_tmp = $_FILES['file']['tmp_name'];

    $command = "/usr/bin/python3 " . FIGURE_EXTRACTION_SERVICE_PATH . "test/rundetection.py " . $file_tmp;

    shell_exec($command);
}