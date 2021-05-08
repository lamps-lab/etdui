<?php

require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
include '../../src/mysql_login.php';
require_once '../../src/search_history.php';

session_start();

$sql = "SELECT * FROM figure_search_history WHERE user='" . $_SESSION['user_id'] . "';";

$results = $connection->query($sql);
?>

<body>
    <?php include 'menu.php' ?>
    <div class="results">

        <br>
        <h1> Search History </h1><br>

        <button class="advanced-search-button" style="margin-right: 10px;" onclick="deleteCheckedHistory()">Clear Selected &#128465</button>
        <form action="../../src/elasticsearch/handle_history.php" method="POST">
            <button class="advanced-search-button" name="clear" onclick="deleteCheckedHistory()">Clear All History</button>
        </form>
        <br><br><br><br>

        <?php while ($row = $results->fetch_assoc()) {
            $search_history = new SearchHistory();
            $search_history->set_id($row['id']);
            $search_history->set_user($_SESSION['user_id']);
            $search_history->set_patent_id($row['patent_id']);
            $search_history->set_text_reference($row['text_reference']);
            $search_history->set_figure_id($row['figure_id']);
            $search_history->set_description($row['description']);
            $search_history->set_aspect($row['aspect']);
            $search_history->set_object($row['object']);
            $search_history->set_date_searched($row['date_searched']);
            $search_history->set_normal_search($row['normal_search']);
            $search_history->set_url($row['url']);

            $search_history->entry();
        }
        ?>
    </div>

    <script src="../js/searchFunctions.js"></script>

</body>

</html>