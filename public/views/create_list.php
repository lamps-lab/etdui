<div class="modal fade" id="create-list-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../src/elasticsearch/handle_list.php" method="POST">
                <div class="modal-header">
                    <slot name="name">
                        <!-- Title input. -->
                        List Name: <input type="text" id="name" name="name" />
                    </slot>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" name="create-list" class="btn btn-primary">Create &#128269;</button>
            </form>
        </div>
    </div>
</div>
</div>