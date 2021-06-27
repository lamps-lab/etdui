<div class="modal fade" id="insert-entry-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../src/elasticsearch/insert_action.php" method="POST">
                <div class="modal-header">
                    <slot name="title">
                        <!-- Title input. -->
                        Title: <input type="text" id="title" name="title" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="url">
                        <!-- Title input. -->
                        Source URL: <input type="text" id="url" name="url" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="author">
                        <!-- Input box for the author. -->
                        Author: <input type="text" id="author" name="author" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="abstract">
                        <!-- Input box for the abstract. -->
                        Abstract: <input type="text" id="abstract" name="abstract" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="publisher">
                        <!-- Input box for the publisher. -->
                        Publisher: <input type="text" id="publisher" name="publisher" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="subject">
                        <!-- Input box for the publisher. -->
                        Subject: <input type="text" id="subject" name="subject" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="department">
                        <!-- Input box for the department. -->
                        Department: <input type="text" id="department" name="department" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="degree">
                        <!-- Input box for the degree name. -->
                        Degree: <input type="text" id="degree" name="degree" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="date">
                        <!-- Input boxes for publication date range. -->
                        Date: <input type="text" placeholder="YYYY-MM-DD" id="date" name="date" required/>
                       
                    </slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" name="insert" class="btn btn-primary">Insert</button>
            </form>
        </div>
    </div>
</div>
</div>