<?php

require '../../vendor/autoload.php';
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
include '../../src/mysql_login.php';
require_once '../../src/user_list.php';

// Query for all of the lists created by the user for the dissertation.
$sql = "SELECT * FROM user_dissertation_lists WHERE user='" . $_SESSION['user_id'] . "';";

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

        <?php 
        
        // Iterate through all of the lists created by the current user.
        while ($row = $results->fetch_assoc()) {
            
            // Set the current user list iterated.
            $list = new UserList();
            $list->set_id($row['id']);
            $list->set_name($row['name']);
            
            // Set checkbox for the current list.
            echo '<input type="checkbox" class="delete" style="float:left" id="' . $list->get_id() . '" value="' . $list->get_id() . '">';
            echo '<form action = "../../public/views/list_items.php" method="get" id="' . $list->get_id() . '-list">';
            echo '<input type="hidden" name="list-name" value="' . $list->get_name() . '" />';
            echo '<button type="submit" class="dissertation-title" name="list-id" value="' . $list->get_id() . '">' . $list->get_name() . "</button>";
            echo '</form>';
        }

        ?>
    </div>

    <script src="../js/searchFunctions.js"></script>

</body>

</html>