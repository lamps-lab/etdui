<?php include 'header.php' ?>

<body>
    <?php
     include 'menu.php';
     include '../../constants.php';

     if (isset($_GET['file-id'])) {
         $file_id = $_GET['file-id'];

         $images = glob(USER_FILES . $_SESSION["user_id"] . "/$file_id/$file_id". "_results_v2/output/output/" . "/*.png");

         $figures_json = json_decode(file_get_contents($json_file), true);
         echo "<div class='results-container'>";
         echo "<div class='container'>";
         foreach($images as $img) {
            echo "<div class='row border border-secondary'>";
             $b64image = base64_encode(file_get_contents($img));
             echo "<img src='data:image/png;base64,$b64image'>";
             echo "</div>";
         }
         echo "</div></div>";
     }
     ?>