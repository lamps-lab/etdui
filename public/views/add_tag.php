<!-- Pop up modal that prompts user for more detailed search information. The format was
  taken from bootstrap, https://getbootstrap.com/docs/4.0/components/modal/ and the inputs
  for advanced search were implemented by me. -->
<div class="modal fade" id=<?php echo "add-tag-" . $this->get_id() ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
 

            if (isset($_SESSION['user_id'])) {
                echo "<div class='modal-header'>
                    <slot name='tag'>
                        <!-- Title input. -->
                        Add Tag: <input type='text' id='tag-" . $this->get_id() . "' placeholder='Add tag'></input>
                    </slot>
                </div>";
            }

            include '../../src/mysql_login.php';

            // echo $this->get_id();

            $query = "SELECT * FROM tags WHERE figure='" . $this->get_id() . "';";

            $results = $connection->query($query);

            while ($row = $results->fetch_assoc()) {
                echo '<form action="../../public/views/tagged_figures.php" method="get">';
                echo '<button style="float: left;" class="tag" class="tag" type="submit" name="tag" value="' . $row['name'] . '">' . $row['name'] . '</button>';
                echo '</form>';
                echo '&nbsp;';
            }

            ?>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo "<button onClick='addTag(" . $this->get_id() . ")' type='button' value='added' class='btn btn-primary'>Add Tag</button>";
                    echo "<p class='error' id='tag-error' hidden></p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>