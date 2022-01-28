<div class="faceted-search-container">
    <form action="../../src/elasticsearch/results.php" method="GET">
        <div class="attribute"> <label class="attribute-label"> Title: </label> <input class="attribute-input" id="title" name="title" value="<?php echo $title_v ?>"/> </div>
        <div class="attribute"> <label class="attribute-label"> Author: </label> <input class="attribute-input" id="author" name="author" value="<?php echo $author_v ?>"/> </div>
        <div class="attribute"><span id="authors-span"></span></div>
        <div class="attribute"> <button type="button" class="show-authors" id="show-authors" onclick="showAuthors()">More Authors</button></div>
        <div class="attribute"> <label class="attribute-label"> Abstract: </label> <input class="attribute-input" id="abstract" name="abstract" value="<?php echo $abstract_v ?>"/> </div>
        <div class="attribute"> <label class="attribute-label"> University: </label>  <input class="attribute-input" id="publisher" name="publisher" value="<?php echo $publisher_v ?>" /> </div>
        <div class="attribute"> <label class="attribute-label"> Subject: </label>  <input class="attribute-input" id="subject" name="subject" value="<?php echo $subject_v ?>"  /> </div>
        <div class="attribute"> <label class="attribute-label"> Department: </label>  <input class="attribute-input" id="department" name="department" value="<?php echo $department_v ?>" /> </div>
        <div class="attribute"> <label class="attribute-label"> Degree: </label> <input class="attribute-input" id="degree" name="degree" /> </div>
        Issued Between: <br><br> </label> <input type="text" placeholder="YYYY" id="start_date" value="<?php echo $beg_date_v ?>" name="start_date" style="width: 100px" />
         — <input type="text" id="end_date" placeholder="YYYY" name="end_date" value="<?php echo $end_date_v ?>" style="width: 100px" />
        <br><br>
        <button class="advanced-search-button center" name="advanced_search">Submit</button>
    </form>
</div>