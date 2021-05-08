<?php

class Figure
{
    private $id;
    private $patent_id;
    private $text_reference;
    private $figure_id;
    private $subfig;
    private $description;
    private $aspect;
    private $object;
    private $likes;
    private $liked;
    private $date;

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function set_patent_id($patent_id)
    {
        $this->patent_id = $patent_id;
    }

    function get_patent_id()
    {
        return $this->patent_id;
    }

    function set_date($date)
    {
        $this->date = $date;
    }

    function get_date()
    {
        return $this->date;
    }

    function set_text_reference($text_reference)
    {
        $this->text_reference = $text_reference;
    }

    function get_text_reference()
    {
        return $this->text_reference;
    }

    function set_figure_id($figure_id)
    {
        $this->figure_id = $figure_id;
    }

    function get_figure_id()
    {
        return $this->figure_id;
    }

    function set_subfig($subfig)
    {
        $this->subfig = $subfig;
    }

    function get_subfig()
    {
        return $this->subfig;
    }

    function set_description($description)
    {
        $this->description = $description;
    }

    function get_description()
    {
        return $this->description;
    }

    function set_aspect($aspect)
    {
        $this->aspect = $aspect;
    }

    function get_aspect()
    {
        return $this->aspect;
    }

    function set_object($object)
    {
        $this->object = $object;
    }

    function get_object()
    {
        return $this->object;
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

    function display_result($entry)
    {
        require_once "../../constants.php";

        $current_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $image = FIGURES_PATH . $this->get_patent_id() . "-D0000" . $this->get_figure_id() . ".png";

        $b64image = base64_encode(file_get_contents($image));

        $likes = $this->number_of_likes();

            include "../../public/views/add_to_list.php";
            include "../../public/views/add_tag.php";

            echo '<div class="figure-result">';
            echo '<button type="button" class="add-to-list" data-toggle="modal" data-target="#add-to-list-' . $this->get_id() . '"></button>';
            echo '<form name="summary-form" id="summary-form" action="../../public/views/summary.php" method="get">';
            echo "<input type='hidden' name='previous-url' value='$current_url'/>";
            echo "<div data-toggle='modal' data-target='#add-tag-" . $this->get_id() . "'>";

            if (file_exists($image)) {
                echo "<img src='data:image/png;base64,$b64image' alt='" . $this->get_description() . "' width='206.5' height='294.25'><br><br>";
            } else {
                $image = FIGURES_PATH . "image_not_found.PNG";
                $b64image = base64_encode(file_get_contents($image));
                echo "<img src='data:image/png;base64,$b64image' alt='" . $this->get_description() . "' width='206.5' height='294.25'><br><br>";
            }
            
            echo "</div>";
            echo '<button type="submit" class="dissertation-title" name="id" value="' . $this->get_id() . '">' . $this->get_patent_id() . '</button><br><br>';
            echo $this->get_description() . '<br><br>';


            if (isset($_SESSION['user_id'])) {
                $like_class = "like";

                if ($this->liked_by_user($_SESSION['user_id'])) {
                    $like_class = "liked";
                }

                echo '<br><button type="button" class="' . $like_class . '" id="' . $entry . '-like" onClick="handleLike(' . $entry . ')" value="' . $this->get_id() . '"></button>';
            }

            echo '<p class="likes" id="' . $entry . '-likes">' . $likes . ' Like(s)</p>';

            echo '</form><br>';


            echo "<form action='../../src/elasticsearch/download_figure.php' method='post'>
                <button class='download' value='" . $this->get_patent_id() . "-D0000" . $this->get_figure_id() . "'name='download_id' type='submit'>Download</button>
                </form></div>";
    }

    function has_likes()
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM liked_figures WHERE figure_id='" . $this->get_id() .
            "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    function liked_by_user($user_id)
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_figure_likes WHERE figure_id='" . $this->get_id() .
            "' AND user='" . $user_id . "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    function number_of_likes()
    {
        include '../../src/mysql_login.php';

        // Get the number of likes from the liked dissertations.
        $query = "SELECT likes FROM liked_figures WHERE figure_id='" .
            $this->get_id() . "';";

        $results = $connection->query($query);

        $likes = 0;

        while ($row = $results->fetch_assoc()) {
            $likes = $row['likes'];
        }

        return $likes;
    }

    function like_figure($user_id)
    {
        include '../mysql_login.php';

        $sql = "INSERT INTO user_figure_likes(user, figure_id) VALUES" .
            "('" . $user_id . "', '" . $this->get_id() . "');";

        $connection->query($sql);

        if ($this->has_likes()) {

            // Get the number of likes from the liked dissertations.
            $likes = $this->number_of_likes();

            $updated_likes = $likes + 1;

            // If the dissertation already has likes, increment the number of likes on the existing table.
            $sql = "UPDATE liked_figures SET likes=" . $updated_likes . " WHERE figure_id='" . $this->get_id() . "';";

            $connection->query($sql);
        } else {
            // If the dissertation is not in liked dissertations, add it there.
            $sql = "INSERT INTO liked_figures(figure_id, likes)" .
                "VALUES ('" . $this->get_id() . "', " . 1 . ");";

            $connection->query($sql);
        }
    }

    function unlike_figure($user_id)
    {
        include '../mysql_login.php';

        // Get the number of likes from the liked dissertations.
        $likes = $this->number_of_likes();

        $updated_likes = $likes - 1;

        if ($likes > 1) {
            // If the dissertation already has likes, increment the number of likes on the existing table.
            $sql = "UPDATE liked_figures SET likes=" . $updated_likes . " WHERE figure_id='" . $this->get_id() . "';";

            $connection->query($sql);
        } else {
            // Remove the dissertation from the liked dissertation table if there is only 1 like.
            $sql = "DELETE FROM liked_figures WHERE figure_id='"
                . $this->get_id() . "';";

            $connection->query($sql);
        }

        // Delete from user likes table.
        $sql = "DELETE FROM user_figure_likes WHERE figure_id='" . $this->get_id() .
            "' AND user='" . $user_id . "';";

        $connection->query($sql);
    }

    function summary()
    {
        session_start();
        require_once "tag.php";
        include 'mysql_login.php';

        $image = FIGURES_PATH . $this->get_patent_id() . "-D0000" . $this->get_figure_id() . ".png";
        $b64image = base64_encode(file_get_contents($image));

        echo "<div class='content'>
        <div>
        <div class='left-panel'>

        <img src='data:image/png;base64,$b64image' alt='" . $this->get_description() . "' width='206.5' height='294.25'><br>

        <h4> Patent ID: " . $this->get_patent_id() . "</h4><br>
        <b><u>Figure ID:</u></b> &nbsp;" . $this->get_figure_id() . "<br><br>
        <b><u>Text Reference(s):</u></b> &nbsp;" . $this->get_text_reference() . "<br><br>
        <b><u>Description:</u></b> &nbsp;" . $this->get_description() . "<br><br>
        <b><u>Aspect:</u></b> &nbsp;" . $this->get_aspect() . "<br><br>
        <b><u>Object:</u></b> &nbsp;" . $this->get_object() . "<br><br>
        <b><u>Patent Date:</u></b>&nbsp;" . $this->get_date() . "<br><br>";

        if (isset($_SESSION['user_id'])) {
            echo "<input type='text' id='tag' placeholder='Add tag'></input>
            <button class='add-tag' onClick='addTag(" . $this->get_id() . ")'> Add Tag </button>
            <p class='error' id='tag-error' hidden></p>
            <br><br>";
        }

        $query = "SELECT * FROM tags WHERE user='"
            . $_SESSION['user_id'] . "' AND figure='" . $this->get_id() . "';";

        $results = $connection->query($query);

        echo '<div class="tags">';
        while ($row = $results->fetch_assoc()) {
            // If the user added the tag, give them the option of removing the tag.
            echo '<form class="tag" action="../../public/views/tagged_figures.php" method="get">';
            echo '<button class="user-tag" id="' . $row['id'] . '" type="submit" name="tag" value="' . $row['name'] . '">' . $row['name'] . '</button>';
            echo '<button class="remove-tag" type="button" id="remove-' . $row['id'] . '" onClick="removeTag(' . $row['id'] . ')">&#10006;</button>';
            echo '</form>';
            echo '&nbsp;';
        }

        $query = "SELECT * FROM tags WHERE user<> '"
            . $_SESSION['user_id'] . "' AND figure='" . $this->get_id() . "';";

        $results = $connection->query($query);

        while ($row = $results->fetch_assoc()) {
            echo '<form  class="tag" action="../../public/views/tagged_figures.php" method="get">';
            echo '<button class="tag" type="submit" name="tag" value="' . $row['name'] . '">' . $row['name'] . '</button>';
            echo '</form>';
            echo '&nbsp;';
        }

        echo '</div>';

        echo '<br><br><br></div>';

        include "../../public/views/annotation_panel.php";

        echo "</div><div class='bottom-panel'>
        <form action='../../src/elasticsearch/download_figure.php' method='post'>
        <button class='download' value='" . $this->get_patent_id() . "-D0000" . $this->get_figure_id() . "'name='download_id' type='submit'>Download</button>
        </form>
        <br><br>
        </div>
    </div>";
    }
}
