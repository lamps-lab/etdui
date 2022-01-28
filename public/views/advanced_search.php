<!-- Pop up modal that prompts user for more detailed search information. The format was
  taken from bootstrap, https://getbootstrap.com/docs/4.0/components/modal/ and the inputs
  for advanced search were implemented by me. -->
<div class="modal fade" id="advanced-search-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Advanced Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../../src/elasticsearch/results.php" method="GET">
                <div class="modal-header">
                    <slot name="title">
                        <!-- Title input. -->
                        <div style="float: left; width: 20%;">Title:</div> <input type="text" id="title"  name="title" style="float: right; width: 50%;" value="<?php echo $title_v ?>" />
                        <button type="button" style="float: left; width: 20%;" id="mic-title" onclick="speechToText('mic-title', 'title')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="author">
                        <!-- Input box for the author. -->
                        <div style="float: left; width: 20%;">Author:</div> <input type="text" id="author" name="author" style="float: right; width: 50%;" value="<?php echo $author_v ?>" />
                        <button type="button" style="float: left; width: 20%;" id="mic-author" style="float: right;" onclick="speechToText('mic-author', 'author')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="abstract">
                        <!-- Input box for the abstract. -->
                        <div style="float: left; width: 20%;">Abstract:</div> <input type="text" id="abstract" style="float: left; width: 50%;" name="abstract" value="<?php echo $abstract_v ?>" />
                        <button type="button" id="mic-abstract" style="float: left; width: 20%;" onclick="speechToText('mic-abstract', 'abstract')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="publisher">
                        <!-- Input box for the publisher. -->
                        <div style="float: left; width: 20%;">University:</div> <input type="text" id="publisher" style="float: left; width: 50%;" name="publisher" value="<?php echo $publisher_v ?>" />
                        <button type="button" id="mic-publisher" style="float: left; width: 20%;" onclick="speechToText('mic-publisher', 'publisher')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="subject">
                        <!-- Input box for the publisher. -->
                        <div style="float: left; width: 20%;">Subject:</div> <input type="text" id="subject" style="float: left; width: 50%;" name="subject" value="<?php echo $subject_v ?>" />
                        <button type="button" id="mic-subject" style="float: left; width: 20%;" onclick="speechToText('mic-subject', 'subject')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="department">
                        <!-- Input box for the department. -->
                        <div style="float: left; width: 20%;">Department:</div> <input type="text" id="department" style="float: left; width: 50%;" name="department" value="<?php echo $department_v ?>" />
                        <button type="button" id="mic-department" style="float: left; width: 20%;" onclick="speechToText('mic-department', 'department')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="degree">
                        <!-- Input box for the degree name. -->
                        <div style="float: left; width: 20%;">Degree:</div> <input type="text" id="degree" style="float: left; width: 50%;" name="dgree" value="<?php echo $degree_v ?>" />
                        <button type="button" id="mic-degree" style="float: left; width: 20%;" onclick="speechToText('mic-degree', 'degree')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="date-range">
                        <!-- Input boxes for publication date range. -->
                        Issued between: <input type="text" placeholder="YYYY" id="start_date" value="<?php echo $beg_date_v ?>" name="start_date" style="width: 100px" />
                        —
                        <input type="text" id="end_date" placeholder="YYYY" name="end_date" value="<?php echo $end_date_v ?>" style="width: 100px" />
                    </slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" name="advanced_search" class="btn btn-primary">Search &#128269;</button>
            </form>
        </div>
    </div>
</div>
</div>