<?php


if (isset($_POST['download_id'])) {

    include '../../constants.php';

    $figure = $_POST['download_id'];

    // The path where your dissertation directory will be.
    $path = FIGURES_PATH . $figure . ".png";


    // If there is only one PDF file, download the single PDF.
    header("Content-type:application/pdf");
    header("Content-Disposition:attachment;filename=" . $figure . ".png");
    readfile($path);
}
