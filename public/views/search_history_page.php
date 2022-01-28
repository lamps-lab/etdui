<?php

require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
include '../../src/mysql_login.php';
require_once '../../src/search_history.php';

session_start();

$sql = "SELECT * FROM search_history WHERE user='" . $_SESSION['user_id'] . "';";

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
            $search_history->set_title($row['title']);
            $search_history->set_author($row['author']);
            $search_history->set_abstract($row['abstract']);
            $search_history->set_publisher($row['publisher']);
            $search_history->set_subject($row['subject']);
            $search_history->set_department($row['department']);
            $search_history->set_degree($row['degree']);
            $search_history->set_beg_date($row['beg_date']);
            $search_history->set_end_date($row['end_date']);
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