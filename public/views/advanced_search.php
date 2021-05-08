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
                    <slot name="patent-id">
                        <!-- Title input. -->
                        Patent ID: <input type="text" id="patent-id" name="patent-id" value="<?php echo $patent_id_v ?>" />
                        <button type="button" id="mic-patent-id" onclick="speechToText('mic-patent-id', 'patent-id')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="text-reference">
                        <!-- Input box for the author. -->
                        Text Reference: <input type="text" id="text-reference" name="text-reference" value="<?php echo $text_reference_v ?>" />
                        <button type="button" id="mic-text-reference" onclick="speechToText('mic-text-reference', 'text-reference')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="figure-id">
                        <!-- Input box for the abstract. -->
                        Figure ID: <input type="text" id="figure-id" name="figure-id" value="<?php echo $figure_id ?>" />
                        <button type="button" id="mic-figure-id" onclick="speechToText('mic-figure-id', 'figure-id')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="description">
                        <!-- Input box for the publisher. -->
                        Description: <input type="text" id="description" name="description" value="<?php echo $description_v ?>" />
                        <button type="button" id="mic-description" onclick="speechToText('mic-description', 'description')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="aspect">
                        <!-- Input box for the publisher. -->
                        Aspect: <input type="text" id="aspect" name="aspect" value="<?php echo $aspect_v ?>" />
                        <button type="button" id="mic-aspect" onclick="speechToText('mic-aspect', 'aspect')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="object">
                        <!-- Input box for the department. -->
                        Object: <input type="text" id="object" name="object" value="<?php echo $object_v ?>" />
                        <button type="button" id="mic-object" onclick="speechToText('mic-object', 'object')" class="btn btn-primary">&#127908</button>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="multiple">
                        <!-- Input box for the department. -->
                        Multiple Figures: <input type="checkbox" id="multiple" name="multiple"/>
                    </slot>
                </div>
                <div class="modal-header">
                    <slot name="caption">
                        <!-- Input box for the department. -->
                        Has Caption: <input type="checkbox" id="caption" name="caption"/>
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