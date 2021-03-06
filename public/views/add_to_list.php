<div class="modal fade" id=<?php echo "add-to-list-" . $this->get_id() ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="add-to-list-modal-<?php echo $this->get_id()?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add To List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php

                require_once "../../src/user_list.php";
                include '../../src/mysql_login.php';

                $query = "SELECT * FROM user_lists WHERE user='" . $_SESSION['user_id'] . "'";
                $results = $connection->query($query);

                while ($row = $results->fetch_assoc()) {
                    echo '<div class="modal-header">';
                    echo '<slot>';
                    echo $row['name'];

                    $user_list = new UserList();
                    $user_list->set_id($row['id']);
                    $user_list->set_user($row['user']);

                    if ($user_list->in_list($this->get_id())) {
                        echo '<input type="checkbox" onClick="handleListItem(\'' . $user_list->get_id() . '\',\'' . $user_list->get_user() . '\',\'' . $this->get_id() . '\')" checked>';
                    } else {
                        echo '<input type="checkbox" onClick="handleListItem(\'' . $user_list->get_id() . '\',\'' . $user_list->get_user() . '\',\'' . $this->get_id() . '\')">';
                    }
                    echo '</slot></div>';
                }

                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="button" onClick="appendAddListElement('<?php echo $this->get_id() ?>')" name="new-list" id="new-list" class="btn btn-primary">New List</button>
            </div>
        </div>
    </div>
</div>