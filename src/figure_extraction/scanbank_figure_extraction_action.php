<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

$user_id = $_SESSION["user_id"];

include '../../constants.php';

$file_name = $_FILES['fileToUpload']['name'];

$im = new Imagick();

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

        $file_results_dir = $file_dir . "/" . $file_count . "_results_v2";
            
        if (!file_exists($file_results_dir)) {
            mkdir($file_results_dir);
        }

        move_uploaded_file($file_tmp, "$file_results_dir/$file_name");
        $file_path = "$file_results_dir/$file_name";
        $im->readImage($file_path);
        mkdir("$file_results_dir/input");
        mkdir("$file_results_dir/output");
        $im->writeImages("$file_results_dir/input/$file_name.png", false);

        $command = "docker run -it --ipc=host -v $file_results_dir/input:/usr/src/app/input_images -v $file_results_dir/output:/usr/src/app/inference sampyash/yolov5:airflow_integration /bin/bash -c 'python detect.py --source input_images --weights ./weights/best.pt --conf 0.4 --save-txt --output inference/output && chmod -R 777 /usr/src/app/inference'";
        exec($command);

        $images = glob("$file_results_dir/output/output" . "/*.png");

        foreach ($images as $img)
        {
            $page_name = basename($img, ".png");
            echo $page_name . "<br>";
            if (!file_exists("$file_results_dir/output/output/$page_name.txt")) {
                unlink($img);
            }
        }

        $files = glob("$file_results_dir/input/*");
        foreach($files as $file){
            if(is_file($file)) {
              unlink($file);
            }
        }

        rmdir("$file_results_dir/input");

        header("Location: /public/views/extracted_figures_v2.php?file-id=$file_count");
    }

}