<?php


if (isset($_POST['download_id'])) {

    $dissertation_id = $_POST['download_id'];

    // The path where your dissertation directory will be.
    $path = "/mnt/d/Documents/CS518/dissertation/" . $dissertation_id . "/";

    // Get all of the files in the directory.
    $dir = scandir($path);

    $counter = 0;

    $pdf_names = [];

    $pdf_files = [];

    foreach ($dir as $file) {

        // If the file type is PDF, download the file to the user's computer.
        if (mime_content_type($path . $file) == 'application/pdf') {

            // Push file path to array of PDF files.
            array_push($pdf_files, $path . $file);

            // Push file name to array of PDF names.
            array_push($pdf_names, $file);

            $counter += 1;
        }
    }

    if ($counter == 1) {
        // If there is only one PDF file, download the single PDF.
        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=" . $pdf_names[0]);
        readfile($pdf_files[0]);
    }

    if ($counter > 1) {

        // If there are more than 1 PDF files, download all the files
        // inside of a zip file.

        $zip = new ZipArchive;

        $i = 0;

        $zip_name = $dissertation_id . '.zip';

        // Create a ZIP file.
        $zip->open($zip_name, ZipArchive::CREATE);

        foreach ($pdf_files as $pdf) {
            $pdf_name = $pdf_names[$i];

            // Add each PDF file for the dissertation into the ZIP file.
            $zip->addFile($pdf, $pdf_name);
            $i += 1;
        }

        $zip->close();

        // Download the ZIP file onto the users computer.
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zip_name);
        header('Content-Length: ' . filesize($zip_name));
        readfile($zip_name);

        // After zip file is downloaded, delete it from the server.
        unlink($zip_name);
    }
}
