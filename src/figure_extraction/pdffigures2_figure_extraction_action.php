<?php

session_start();

$user_id = $_SESSION["user_id"];

include '../../constants.php';

$file_name = $_FILES['fileToUpload']['name'];


if (isset($_FILES['fileToUpload'])) {
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];

    if (mime_content_type($file_tmp) == "application/pdf") {

        $user_dir = USER_FILES . "$user_id";

        if (!file_exists($user_dir)) {
            mkdir($user_dir);
        }

        $file_dir = "";

        $file_count = count(glob($user_dir));

        $file_dir = "$user_dir/$file_count";

        if (!file_exists($file_dir)) {
            mkdir($file_dir);
        }

        $file_results_dir = $file_dir . "/" . $file_count . "_results";
            
        if (!file_exists($file_results_dir)) {
            mkdir($file_results_dir);
        }

        move_uploaded_file($file_tmp, "$file_results_dir/$file_name.pdf");

        chdir(PDFFIGURES2);
        $command = "sbt 'runMain org.allenai.pdffigures2.FigureExtractorBatchCli $file_results_dir/$file_name.pdf -s $file_dir/stat_file.json -m $file_results_dir/ -d $file_results_dir/'";
        exec($command);

        header("Location: /public/views/extracted_figures.php?file-id=$file_count");

    }

}