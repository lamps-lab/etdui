<?php

include '../../constants.php';

include "../../src/mysql_login.php";

$sql = "SELECT * FROM annotations WHERE figure='" . $this->get_id() . "';";
$results = $connection->query($sql);

$segmented_correctly = $subfigures_correct = $objects_correct = $aspect_correct = 1;
$subfigure_labels = $num_segments = $object_label = $aspect_label = "";


while ($row = $results->fetch_assoc()) {
    $segmented_correctly = $row['segmented_correctly'];
    $subfigures_correct = $row['subfigures_correct'];
    $objects_correct = $row['object_correct'];
    $aspect_correct = $row['aspect_correct'];
    $subfigure_labels = $row['subfigure_labels'];
    $num_segments = $row['num_segments'];
    $object_label = $row['object_label'];
    $aspect_label = $row['aspect_label'];
}
?>

<div class="right-panel">
    <?php
        $img_path = FIGURES_PATH . $this->get_patent_id() . "-D0000" . $this->get_figure_id();
        if (is_dir($img_path)) {
            $dir = new FilesystemIterator($img_path);

            foreach ($dir as $img) {
                $b64image = base64_encode(file_get_contents($img));
                echo "<img src='data:image/png;base64,$b64image' alt='" . $this->get_description() . "' width='140.25' height='147.125' class='image-border'> &nbsp;";
            }
        }
    ?>
    <form onsubmit="combineLabels()" action="../../src/elasticsearch/annotation_action.php" method="POST">
        <b><h2>Subfigures Segmented </h2></b>
        <p> Are subfigures segmeneted correctly? </p>
        <?php

        if ($segmented_correctly == 1) {
            echo '<input type="radio" name="segmented-correctly" id="yes-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=1 checked>Yes</input>';
        } else {
            echo '<input type="radio" name="segmented-correctly" id="yes-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=1>Yes</input>';
        }
        
        if ($segmented_correctly == 0) {
            echo '<input type="radio" name="segmented-correctly" id="no-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=-1 checked>No</input>';
        } else {
            echo '<input type="radio" name="segmented-correctly" id="no-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=-1>No</input>';
        }

        if ($segmented_correctly == "NULL") {
            echo '<input type="radio" name="segmented-correctly" id="unlabeled-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=0 checked>Unlabeled</input>';
        } else {
            echo '<input type="radio" name="segmented-correctly" id="unlabeled-segmented-correctly" onClick ="checkSegmentedCorrectly()" value=0>Unlabeled</input>';
        }

        if ($segmented_correctly == 0 || $segmented_correctly == "NULL") {
            echo "<br><p><b>Subfigures Segmented:</b> $num_segments";
        }

        ?>
        <div class="segmented-correctly"></div>
        <br><br>

        <b><h2>Subfigure Labels </h2></b>
        <p> Are subfigures labeled correctly? </p>

        <?php
        if ($subfigures_correct == 1) {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="yes-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=1 checked>Yes</input>';
        } else {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="yes-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=1>Yes</input>';
        }

        if ($subfigures_correct == 0) {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="no-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=-1 checked>No</input>';
        } else {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="no-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=-1>No</input>';
        }

        if ($subfigures_correct == "NULL") {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="unlabeled-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=0 checked>Unlabeled</input>';
        } else {
            echo '<input type="radio" name="subfigures-labeled-correctly" id="unlabeled-label-subfigures" onClick ="checkLabeledCorrectly(\'label-subfigures\')" value=0>Unlabeled</input>';
        }

        if ($subfigures_correct == 0 || $subfigures_correct == "NULL") {
            echo "<br><p><b>Subfigure Labels:</b> $subfigure_labels";
        }
        ?>
        <div class="enter-correct-labels-label-subfigures"></div>
        <br><br>

        <b><h2>Objects </h2></b>
        <p> Are objects identified correctly? </p>
        <?php
        if ($objects_correct == 1) {
            echo '<input type="radio" name="objects-labeled-correctly" id="yes-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=1 checked>Yes</input>';
        } else {
            echo '<input type="radio" name="objects-labeled-correctly" id="yes-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=1>Yes</input>';
        }
        if ($objects_correct == 0) {
            echo '<input type="radio" name="objects-labeled-correctly" id="no-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=-1 checked>No</input>';
        } else {
            echo '<input type="radio" name="objects-labeled-correctly" id="no-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=-1>No</input>';
        }

        if ($objects_correct == "NULL") {
            echo '<input type="radio" name="objects-labeled-correctly" id="unlabeled-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=0 checked>Unlabeled</input>';
        } else {
            echo '<input type="radio" name="objects-labeled-correctly" id="unlabeled-label-objects" onClick ="checkLabeledCorrectly(\'label-objects\')" value=0>Unlabeled</input>';
        }

        if ($objects_correct == 0 || $objects_correct == "NULL") {
            echo "<br><p><b>Object Labels:</b> $object_label";
        }
        ?>
        <div class="enter-correct-labels-label-objects"></div>
        <br><br>

        <b><h2>Aspects </h2></b>
        <p> Are aspects identified correctly? </p>
        <?php
        if ($aspect_correct == 1) {
            echo '<input type="radio" name="aspects-labeled-correctly" id="yes-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=1 checked>Yes</input>';
        } else {
            echo '<input type="radio" name="aspects-labeled-correctly" id="yes-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=1>Yes</input>';
        }

        if ($aspect_correct == 0) {
            echo '<input type="radio" name="aspects-labeled-correctly" id="no-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=-1 checked>No</input>';
        } else {
            echo '<input type="radio" name="aspects-labeled-correctly" id="no-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=-1>No</input>';
        }

        if ($aspect_correct == "NULL") {
            echo '<input type="radio" name="aspects-labeled-correctly" id="unlabeled-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=0 checked>Unlabeled</input>';
        } else {
            echo '<input type="radio" name="aspects-labeled-correctly" id="unlabeled-label-aspects" onClick ="checkLabeledCorrectly(\'label-aspects\')" value=0>Unlabeled</input>';
        }

        if ($aspect_correct == 0 || $aspect_correct == "NULL") {
            echo "<br><p><b>Aspect Labels:</b> $aspect_label";
        }
        ?>

        <div class="enter-correct-labels-label-aspects"></div>

        <input type="hidden" name="url" value=<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?> />

        <button class="submit" name="submit" type="submit" value=<?php echo $this->get_id()?>>Submit</button>
    </form>
</div>