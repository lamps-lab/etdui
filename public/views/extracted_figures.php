<?php include 'header.php' ?>

<body>
    <?php
     include 'menu.php';
     include '../../constants.php';

     if (isset($_GET['file-id'])) {
         $file_id = $_GET['file-id'];

         $path = USER_FILES . $_SESSION["user_id"] . "/$file_id/$file_id". "_results/";

         $json_files = glob("$path*.json");

         $json_file = "";

         foreach ($json_files as $f) {
             $file_name_split = explode("/",$f);
             $short_file_name = $file_name_split[sizeof($file_name_split) - 1];
             
             if ($short_file_name !== "stat_file.json") {
                 $json_file = $f;
                 break;
             }
         }

         $figures_json = json_decode(file_get_contents($json_file), true);
         echo "<div class='results-container'>";
         echo "<div class='container'>";
         foreach($figures_json as $json) {
            echo "<div class='row border border-secondary'>";
             $b64image = base64_encode(file_get_contents($json["renderURL"]));
             echo "<img src='data:image/png;base64,$b64image'>";
             echo "</div>";
             echo "<div class='row'>";
             echo $json["caption"];
             echo "</div>";
         }
         echo "</div></div>";
     }
     ?>
     