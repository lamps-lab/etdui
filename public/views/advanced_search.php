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
                        Title: <input type="text" id="title" name="title" value="<?php echo $title_v ?>" />
                        <button type="button" id="mic-title" onclick="speechToText('mic-title', 'title')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="author">
                        <!-- Input box for the author. -->
                        Author: <input type="text" id="author" name="author" value="<?php echo $author_v ?>" />
                        <button type="button" id="mic-author" onclick="speechToText('mic-author', 'author')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="abstract">
                        <!-- Input box for the abstract. -->
                        Abstract: <input type="text" id="abstract" name="abstract" value="<?php echo $abstract_v ?>" />
                        <button type="button" id="mic-abstract" onclick="speechToText('mic-abstract', 'abstract')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="publisher">
                        <!-- Input box for the publisher. -->
                        Publisher: <input type="text" id="publisher" name="publisher" value="<?php echo $publisher_v ?>" />
                        <button type="button" id="mic-publisher" onclick="speechToText('mic-publisher', 'publisher')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="subject">
                        <!-- Input box for the publisher. -->
                        Subject: <input type="text" id="subject" name="subject" value="<?php echo $subject_v ?>" />
                        <button type="button" id="mic-subject" onclick="speechToText('mic-subject', 'subject')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="department">
                        <!-- Input box for the department. -->
                        Department: <input type="text" id="department" name="department" value="<?php echo $department_v ?>" />
                        <button type="button" id="mic-department" onclick="speechToText('mic-department', 'department')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="degree">
                        <!-- Input box for the degree name. -->
                        Degree: <input type="text" id="degree" name="dgree" value="<?php echo $degree_v ?>" />
                        <button type="button" id="mic-degree" onclick="speechToText('mic-degree', 'degree')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="date-range">
                        <!-- Input boxes for publication date range. -->
                        Issued between: <input type="text" placeholder="YYYY-MM-DD" id="start_date" value="<?php echo $beg_date_v ?>" name="start_date" style="width: 100px" />
                        —
                        <input type="text" id="end_date" placeholder="YYYY-MM-DD" name="end_date" value="<?php echo $end_date_v ?>" style="width: 100px" />
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