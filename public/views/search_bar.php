<div class="results">
    <br>
    <form class="search" autocomplete="off" style="width: 50%;" action="../../src/elasticsearch/results.php" method="get">
        <input type="text" placeholder="Search..." value="<?php echo $search_v ?>" name="search" id="search" oninput="suggestResults('search')" required>
        <button class="search" type="submit" id="search" name="normal_search">&#128269</button>
        <button class="search" id="microphone" type="button" onclick="speechToText('microphone', 'search')">&#127908;</button>
    </form>
    &nbsp;
    <button type="button" style="width: 20%;" class="advanced-search-button" data-toggle="modal" data-target="#advanced-search-modal">
        Advanced Search &#9881
    </button>

    <br><br><br><br>