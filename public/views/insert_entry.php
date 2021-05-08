<div class="modal fade" id="insert-entry-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../src/elasticsearch/insert_action.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <slot name="patent-id">
                        <!-- Title input. -->
                        Patent ID: <input type="text" id="patent-id" name="patent-id" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="text-reference">
                        <!-- Input box for the author. -->
                        Text Reference: <input type="text" id="text-reference" name="text-reference" />
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="figure-id">
                        <!-- Input box for the abstract. -->
                        Figure ID: <input type="text" id="figure-id" name="figure-id" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="aspect">
                        <!-- Input box for the publisher. -->
                        Aspect: <input type="text" id="aspect" name="aspect"/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="object">
                        <!-- Input box for the publisher. -->
                        Object: <input type="text" id="object" name="object" />
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="description">
                        <!-- Input box for the publisher. -->
                        Description: <input type="text" id="description" name="description" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="pid">
                        <!-- Input box for the department. -->
                        PID: <input type="text" id="pid" name="pid" required/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="subfig">
                        <!-- Input box for the department. -->
                        Subfigure: <input type="text" id="subfig" name="subfig" />
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="multiple">
                        <!-- Input box for the department. -->
                        Multiple Figures: <input type="checkbox" id="multiple" name="multiple" />
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="caption">
                        <!-- Input box for the department. -->
                        Has Caption: <input type="checkbox" id="caption" name="caption" />
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="img">
                        <!-- Input box for the department. -->
                        Upload Image: <input type="file" id="img" name="img" required/>
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