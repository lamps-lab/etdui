<?php

class Dissertation
{
    private $id;
    private $title;
    private $url;
    private $author;
    private $abstract;
    private $preview;
    private $publisher;
    private $subject;
    private $department;
    private $degree;
    private $date;
    private $likes;
    private $liked;
    private $saved;

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function set_title($title)
    {
        $this->title = $title;
    }

    function get_title()
    {
        return $this->title;
    }

    function set_url($url)
    {
        $this->url = $url;
    }

    function get_url()
    {
        return $this->url;
    }

    function set_author($author)
    {
        $this->author = $author;
    }

    function get_author()
    {
        return $this->author;
    }

    function set_abstract($abstract)
    {
        $this->abstract = $abstract;
    }

    function get_abstract()
    {
        return $this->abstract;
    }

    function set_preview($preview)
    {
        $this->preview = $preview;
    }

    function get_preview()
    {
        return $this->preview;
    }

    function set_publisher($publisher)
    {
        $this->publisher = $publisher;
    }

    function get_publisher()
    {
        return $this->publisher;
    }

    function set_subject($subject)
    {
        $this->subject = $subject;
    }

    function get_subject()
    {
        return $this->subject;
    }

    function set_department($department)
    {
        $this->department = $department;
    }

    function get_department()
    {
        return $this->department;
    }

    function set_degree($degree)
    {
        $this->degree = $degree;
    }

    function get_degree()
    {
        return $this->degree;
    }

    function set_date($date)
    {
        $this->date = $date;
    }

    function get_date()
    {
        return $this->date;
    }

    function set_likes($likes)
    {
        $this->likes = $likes;
    }

    function get_likes()
    {
        return $this->likes;
    }

    function set_liked($liked)
    {
        $this->liked = $liked;
    }

    function get_liked()
    {
        return $this->liked;
    }

    function set_saved($saved)
    {
        $this->saved = $saved;
    }

    function get_saved()
    {
        return $this->saved;
    }

    function has_likes()
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM liked_dissertations WHERE dissertation_id='" . $this->get_id() .
            "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    function liked_by_user($user_id)
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_likes WHERE dissertation_id='" . $this->get_id() .
            "' AND user='" . $user_id . "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    function number_of_likes()
    {
        include '../../src/mysql_login.php';

        // Get the number of likes from the liked dissertations.
        $query = "SELECT likes FROM liked_dissertations WHERE dissertation_id='" .
            $this->get_id() . "';";

        $results = $connection->query($query);

        $likes = 0;

        while ($row = $results->fetch_assoc()) {
            $likes = $row['likes'];
        }

        return $likes;
    }

    function is_saved($user_id)
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM favorites WHERE dissertation_id='" . $this->get_id() .
            "' AND user='" . $user_id . "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    // function shorten_abstract($entered_abstract)
    // {
    //     $preview = "";

    //     for ($i = 0; $i < 300; $i++) {

    //         // Create an abstract preview, which is the first
    //         // 300 characters of the abstract.
    //         $preview = $preview . $entered_abstract[$i];
    //     }

    //     return $preview;
    // }

    function result($entry)
    {

        include "../../public/views/add_to_list.php";

        $likes = $this->number_of_likes();

        echo '<form action = "../../public/views/summary.php" method ="get">';
        echo '<button class="dissertation-title" type="submit" name="dissertation-id" value="' . $this->get_id() . '">' . $this->get_title() . '</button><br><br>';
        echo '<b><u>Author(s):</u></b> ' . $this->get_author() . '<br>';
        echo '<b><u>Publisher:</u></b> ' . $this->get_publisher() . '<br>';
        echo '<b><u>Date:</u></b> ' . $this->get_date() . '<br><br>';
        echo '</form>';

        echo "<p><span id='preview-$entry'>". $this->get_preview() . " </span> <span id='dots-$entry'>...</span><span id='show-more-$entry' style='display: none'>" . $this->get_abstract() . "</span></p><br>";

        echo "<button id='show-more-button-$entry' class='download' onClick='showMore($entry)'>Show More</button>";
        echo "<br><br><br><br>";

        $downloadId = $entry . '-download';

        echo '<button type="button" class="add-to-list" data-toggle="modal" data-target="#add-to-list-' . $this->get_id() . '"></button>';

        echo '<form action="../../src/elasticsearch/download_docs.php" method="POST">';
        echo '<button class ="download" name="download_id" id=' . $downloadId . ' type="submit" value="' . $this->get_id() . '">Download</button>';
        echo '</form>';

        if (isset($_SESSION['user_id'])) {
            $save_class = "save";
            $like_class = "like";

            if ($this->is_saved($_SESSION['user_id'])) {
                $save_class = "saved";
            }

            if ($this->liked_by_user($_SESSION['user_id'])) {
                $like_class = "liked";
            }

            echo '<button class=' . $save_class . ' id="' . $entry . '" onclick="handleDissertation(' . $entry . ')" name="dissertation_id" type="button" value="' . $this->get_id() . '"></button>';
            echo '<button class=' . $like_class . ' id="' . $entry . '-like" onclick="handleLike(' . $entry . ')" name="like_id" type="button" value="' . $this->get_id() . '"></button>';
        }

        echo '<p class="likes" id="' . $entry . '-likes">' . $likes . ' Like(s)</p>';
        echo '<br><br><br>';
    }

    function summary()
    {

        session_start();
        require_once "tag.php";
        include 'mysql_login.php';

        echo "<div class='content'>
        <h4>" . $this->get_title() . "</h4><br>
        <b><a href='" . $this->get_url() . "'>" . $this->get_url() . "</a></b><br>
        <b><u>Author(s):</u></b> &nbsp;" . $this->get_author() . "<br>
        <b><u>Publisher:</u></b> &nbsp;" . $this->get_publisher() . "<br>
        <b><u>Date Issued:</u></b> &nbsp;" . $this->get_date() . "<br><br>
        <h5><b><u>Abstract</u></b></h5>
        <div class='container'>" . $this->get_abstract() . "</div>
        <br><br><br>";

        if (isset($_SESSION['user_id'])) {
            echo "<input type='text' id='tag' placeholder='Add tag'></input>
            <button class='add-tag' onClick='addTag(" . $this->get_id() . ")'> Add Tag </button>
            <p class='error' id='tag-error' hidden></p>
            <br><br>";
        }

        $query = "SELECT * FROM dissertation_tags WHERE user='"
            . $_SESSION['user_id'] . "' AND dissertation='" . $this->get_id() . "';";

        $results = $connection->query($query);

        echo '<div class="tags">';
        while ($row = $results->fetch_assoc()) {
            // If the user added the tag, give them the option of removing the tag.
            echo '<form class="tag" action="../../public/views/tagged_dissertations.php" method="get">';
            echo '<button class="user-tag" id="' . $row['id'] . '" type="submit" name="tag" value="' . $row['name'] . '">' . $row['name'] . '</button>';
            echo '<button class="remove-tag" type="button" id="remove-' . $row['id'] . '" onClick="removeTag(' . $row['id'] . ')">&#10006;</button>';
            echo '</form>';
            echo '&nbsp;';
        }

        $query = "SELECT * FROM dissertation_tags WHERE user<> '"
            . $_SESSION['user_id'] . "' AND dissertation='" . $this->get_id() . "';";

        $results = $connection->query($query);

        while ($row = $results->fetch_assoc()) {
            echo '<form  class="tag" action="../../public/views/tagged_dissertations.php" method="get">';
            echo '<button class="tag" type="submit" name="tag" value="' . $row['name'] . '">' . $row['name'] . '</button>';
            echo '</form>';
            echo '&nbsp;';
        }

        echo '</div>';

        echo '<br><br><br>';

        echo "<form action='../../src/elasticsearch/download_docs.php' method='post'>
        <button class='download2' value='" . $this->get_id() . "'name='download_id' type='submit'>Download</button>
        </form>
        <br><br>
    </div>";
    }

    function removeDissertation($user_id)
    {
        include '../mysql_login.php';

        // Remove the dissertation from the user's saved dissertations table.
        $sql = "DELETE FROM favorites WHERE user='" . $user_id . "' AND dissertation_id='"
            . $this->get_id() . "';";

        if ($connection->query($sql) === true) {
            header('Location: ../../public/views/favorites.php');
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    function saveDissertation($user_id)
    {
        include '../mysql_login.php';

        // Save the dissertation into the SQL table.
        $sql = "INSERT INTO favorites" .
            "(user, dissertation_id) " .
            "VALUES ('" . $user_id . "', '" . $this->get_id() . "');";

        if ($connection->query($sql) === true) {
            echo "<script> alert('Entry added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    function like_dissertation($user_id)
    {
        include '../mysql_login.php';

        // Add dissertation to the users likes.
        $sql = "INSERT INTO user_likes(user, dissertation_id) VALUES" .
            "('" . $user_id . "', '" . $this->get_id() . "');";

        $connection->query($sql);

        if ($this->has_likes()) {

            // Get the number of likes from the liked dissertations.
            $likes = $this->number_of_likes();

            $updated_likes = $likes + 1;

            // If the dissertation already has likes, increment the number of likes on the existing table.
            $sql = "UPDATE liked_dissertations SET likes=" . $updated_likes . " WHERE dissertation_id='" . $this->get_id() . "';";

            $connection->query($sql);
        } else {
            // If the dissertation is not in liked dissertations, add it there.
            $sql = "INSERT INTO liked_dissertations(dissertation_id, likes)" .
                "VALUES ('" . $this->get_id() . "', " . 1 . ");";

            $connection->query($sql);
        }
    }

    function unlike_dissertation($user_id)
    {
        include '../mysql_login.php';

        // Get the number of likes from the liked dissertations.
        $likes = $this->number_of_likes();

        $updated_likes = $likes - 1;

        if ($likes > 1) {
            // If the dissertation already has likes, increment the number of likes on the existing table.
            $sql = "UPDATE liked_dissertations SET likes=" . $updated_likes . " WHERE dissertation_id='" . $this->get_id() . "';";

            $connection->query($sql);
        } else {
            // Remove the dissertation from the liked dissertation table if there is only 1 like.
            $sql = "DELETE FROM liked_dissertations WHERE dissertation_id='"
                . $this->get_id() . "';";

            $connection->query($sql);
        }

        // Delete from user likes table.
        $sql = "DELETE FROM user_likes WHERE dissertation_id='" . $this->get_id() .
            "' AND user='" . $user_id . "';";

        $connection->query($sql);
    }
}
