<?php

class Tag
{

    private $id;
    private $dissertation_id;
    private $user;
    private $name;

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function set_dissertation_id($dissertation_id)
    {
        $this->dissertation_id = $dissertation_id;
    }

    function get_dissertation_id()
    {
        return $this->dissertation_id;
    }

    function set_user($user)
    {
        $this->user = $user;
    }

    function get_user()
    {
        return $this->user;
    }

    function set_name($name)
    {
        $this->name = $name;
    }

    function get_name()
    {
        return $this->name;
    }

    function query_tags()
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM dissertation_tags WHERE user='" . $this->get_user() .
            "' AND dissertation='" . $this->get_dissertation_id() . "' AND name='" .
            $this->get_name() . "';";

        return $connection->query($query);
    }

    function has_tag()
    {
        $result = $this->query_tags();

        return ($result->num_rows > 0);
    }

    function add_tag()
    {
        include '../../src/mysql_login.php';

        $sql = "INSERT INTO dissertation_tags(user, dissertation, name) VALUES ('" .
            $this->get_user() . "', '" . $this->get_dissertation_id() .
            "', '" . $this->get_name() . "');";

        if ($connection->query($sql)) {

            return true;

        } else {
            echo $connection->error;
        }
    }

    function remove_tag()
    {
        include '../../src/mysql_login.php';

        $sql = "DELETE FROM dissertation_tags WHERE id='" . $this->get_id() . "';";

        if ($connection->query($sql)) {
            return true;
        } else {
            echo $connection->error;
        }
    }
}
