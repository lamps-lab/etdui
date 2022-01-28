<?php

require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
include '../../src/mysql_login.php';
require_once '../../src/user_list.php';


$sql = "SELECT * FROM user_lists WHERE user='" . $_SESSION['user_id'] . "';";

$results = $connection->query($sql);

?>
<body>
    <?php
     include 'menu.php';
     include 'create_list.php';
     ?>
    <div class="results">

        <br>
        <h1> Lists </h1><br>

        

        <button class="search" style="margin-right: 10px;" data-toggle="modal" data-target="#create-list-modal" >Create New List</button>
        <button class="search" style="margin-right: 10px;" onclick="deleteList()">Clear Selected &#128465</button>
        <form action="../../src/elasticsearch/handle_list.php" method="POST">
            <button class="search" name="delete-all">Delete All Lists</button>
        </form>

        <br><br><br><br><br>

        <?php while ($row = $results->fetch_assoc()) {
            
            $list = new UserList();
            $list->set_id($row['id']);
            $list->set_name($row['name']);
            
            echo '<input type="checkbox" class="delete" style="float:left" id="' . $list->get_id() . '" value="' . $list->get_id() . '">';
            echo '<form action = "../../public/views/list_items.php" method="get" id="' . $list->get_id() . '-list">';
            echo '<input type="hidden" name="list-name" value="' . $list->get_name() . '" />';
            echo '<button type="submit" class="dissertation-title" name="list-id" value="' . $list->get_id() . '">' . $list->get_name() . "</button>";
            echo $list->count_items() . " items";
            echo '</form>';
        }

        ?>
    </div>

    <script src="../js/searchFunctions.js"></script>

</body>

</html>