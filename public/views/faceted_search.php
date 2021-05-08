<div class="faceted-search-container">
    <form action="../../src/elasticsearch/results.php" method="GET">
        <div class="attribute"> <label class="attribute-label"> Patent ID: </label> <input class="attribute-input" id="patent-id" name="patent-id" value="<?php echo $patent_id_v ?>"/> </div>
        <div class="attribute"> <label class="attribute-label"> Figure ID: </label> <input class="attribute-input" id="figure-id" name="figure-id" value="<?php echo $figure_id ?>"/> </div>
        <div class="attribute"> <label class="attribute-label"> Text Reference: </label> <input class="attribute-input" id="text-reference" name="text-reference" value="<?php echo $text_reference_v ?>"/> </div>
        <div class="attribute"> <label class="attribute-label"> Aspect: </label>  <input class="attribute-input" id="aspect" name="aspect" value="<?php echo $aspect_v ?>" /> </div>
        <div class="attribute"> <label class="attribute-label"> Object: </label>  <input class="attribute-input" id="object" name="object" value="<?php echo $object_v ?>"  /> </div>
        <div class="attribute"> <label class="attribute-label"> Description: </label>  <input class="attribute-input" id="description" name="description" value="<?php echo $description_v ?>" /> </div>
        <div class="attribute"> <label class="attribute-label"> Subfigure </label> <input class="attribute-input" id="subfig" name="subfig" /> </div>
        <div class="attribute"> <label class="attribute-label"> Multiple Figures </label> <input class="attribute-input" id="multiple" name="multiple" type="checkbox" <?php if ($multiple == 1) {echo "checked";} ?>/></div>
        <div class="attribute"> <label class="attribute-label"> Has Caption </label> <input class="attribute-input" id="caption" name="caption" type="checkbox" <?php if ($caption == 1) {echo "checked";} ?>/></div>
        <br><br>
        <button class="advanced-search-button center" name="advanced_search">Submit</button>
    </form>
</div>