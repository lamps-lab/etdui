<?php

class SearchHistory
{
    private $id;
    private $user;
    private $patent_id;
    private $text_reference;
    private $figure_id;
    private $description;
    private $aspect;
    private $object;
    private $date_searched;
    private $normal_search;
    private $url;

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function set_user($user)
    {
        $this->user = $user;
    }

    function get_user()
    {
        return $this->user;
    }

    function set_patent_id($patent_id)
    {
        $this->patent_id = $patent_id;
    }

    function get_patent_id()
    {
        return $this->patent_id;
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

    function set_date_searched($date_searched)
    {
        $this->date_searched = $date_searched;
    }

    function get_date_searched()
    {
        return $this->date_searched;
    }

    function set_normal_search($normal_search)
    {
        $this->normal_search = $normal_search;
    }

    function get_normal_search()
    {
        return $this->normal_search;
    }

    function set_url($url)
    {
        $this->url = $url;
    }

    function get_url()
    {
        return $this->url;
    }

    function save_search()
    {

        include '../../src/mysql_login.php';

        $sql = "INSERT INTO figure_search_history(user, patent_id, text_reference, figure_id, "
        . "description, aspect, object, date_searched, normal_search, url) VALUES ('" .
        $this->get_user() . "', '" . $this->get_patent_id() . "', '" . $this->get_text_reference()
        . "', '" . $this->get_figure_id() . "', '" . $this->get_description() . "', '" . $this->get_aspect()
        . "', '" . $this->get_object() . "', '" . $this->get_date_searched() . "', '" . 
        $this->get_normal_search() . "', '" . $this->get_url() . "');";

        if ($connection->query($sql)) {
            return true;
        } else {
            echo $connection->error;
        }
    }


    function is_saved()
    {
        include '../../src/mysql_login.php';

        $sql = "SELECT * FROM figure_search_history WHERE url='" . $this->get_url() . "';";
        $result = $connection->query($sql);

        return ($result->num_rows > 0);
    }

    function clear_search()
    {
        include '../../src/mysql_login.php';

        $sql = "DELETE FROM figure_search_history WHERE url='" . $this->get_url() . "';";

        if ($connection->query($sql)) {
            header('Location: ../../public/views/search_history_page.php');
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    function clear_all()
    {
        include '../../src/mysql_login.php';

        $sql = "DELETE FROM figure_search_history";

        if ($connection->query($sql)) {
            header('Location: ../../public/views/search_history_page.php');
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    function entry()
    {
        echo '<input type="checkbox" class="delete" style="float:left" id="' . $this->get_id() . '" value="' . $this->get_url() . '">';
        echo '<div class="history" data-value="' . $this->get_id() . '-history"  onclick="window.location=\'http://' . $this->get_url() . '\'">';
        if (!empty($this->get_patent_id())) {
            echo '<b> Patent ID:</b> ' . $this->get_patent_id() . '<br>';
        }

        if (!empty($this->get_text_reference())) {
            echo '<b> Text Reference:</b> ' . $this->get_text_reference() . '<br>';
        }

        if (!empty($this->get_figure_id())) {
            echo '<b> Figure ID:</b> ' . $this->get_figure_id() . '<br>';
        }

        if (!empty($this->get_description())) {
            echo '<b> Description:</b> ' . $this->get_description() . '<br>';
        }

        if (!empty($this->get_aspect())) {
            echo '<b> Aspect:</b> ' . $this->get_aspect() . '<br>';
        }

        if (!empty($this->get_object())) {
            echo '<b> Object:</b> ' . $this->get_object() . '<br>';
        }

        if (!empty($this->get_normal_search())) {
            echo '<b> Normal Search:</b> ' . $this->get_normal_search() . '<br>';
        }

        $time_searched = explode(' ', $this->get_date_searched());

        echo '<br><i> Searched on ' . $time_searched[0] . " at " . $time_searched[1] . '</i>';

        echo '</div>';
        echo '<br>';
    }
}
