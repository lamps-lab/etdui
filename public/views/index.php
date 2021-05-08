<?php include 'header.php' ?>

<body>
    <?php include 'menu.php' ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Patent Figure Search
            </div>
            <form class="search" autocomplete="off" action="../../src/elasticsearch/results.php" method="get">
                <input type="text" placeholder="Search..." name="search" id="search" oninput="suggestResults('search')" required>
                <button class="search" id="microphone" type="button" onclick="speechToText('microphone', 'search')">&#127908</button>
                <button class="search" type="submit" name="normal_search"> &#128269</button>
            </form>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<button type="button" class="advanced-search-button" data-toggle="modal" data-target="#advanced-search-modal">
                    Advanced Search &#9881
                </button>';

                echo '<button type="button" style="float: right;" class="advanced-search-button" data-toggle="modal" data-target="#insert-entry-modal">
                Insert Entry
                </button>';
            } else {
                echo '<button type="button" style="width: 70%; float: none;" class="advanced-search-button" data-toggle="modal" data-target="#advanced-search-modal">
                    Advanced Search &#9881
                </button>';
            }

            include 'advanced_search.php';
            include 'insert_entry.php';
            ?>
        </div>
    </div>
    <script src="../js/searchFunctions.js"></script>
</body>

</html>