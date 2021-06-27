<?php

class UserList
{
    private $id;
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

    function in_list($dissertation_id)
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_dissertation_list_items WHERE list='" . $this->get_id() .
            "' AND dissertation_id='" . $dissertation_id . "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    function create_list()
    {
        include '../../src/mysql_login.php';

        session_start();

        $sql = "INSERT INTO user_dissertation_lists (user, name) VALUES ('" .
            $_SESSION['user_id'] . "', '" . $this->get_name() . "');";

        if ($connection->query($sql)) {
            return true;
        } else {
            echo $connection->error;
        }
    }

    function items()
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_dissertation_list_items WHERE user='" . $this->get_user() .
            "' AND list='" . $this->get_id() . "';";

        return $connection->query($query);
    }


    function delete_list()
    {
        include '../../src/mysql_login.php';

        $sql = "DELETE FROM user_dissertation_lists WHERE id='" . $this->get_id() . "';";

        if ($connection->query($sql)) {

            $sql = "DELETE FROM user_dissertation_list_items WHERE list='" . $this->get_id() . "';";

            if ($connection->query($sql)) {
                return true;
            } else {
                echo $connection->error;
            }
        } else {
            echo $connection->error;
        }
    }

    function delete_all_lists()
    {
        include '../../src/mysql_login.php';

        $sql = "DELETE FROM user_dissertation_lists;";

        if ($connection->query($sql)) {

            $sql = "DELETE FROM user_dissertation_list_items WHERE user='" . $this->get_user() . "';";

            if ($connection->query($sql)) {
                header('Location: ../../public/views/lists.php');
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    function add($dissertation_id)
    {
        include '../../src/mysql_login.php';

        $sql = "INSERT INTO user_dissertation_list_items (list, user, dissertation_id)" .
            " VALUES ('" . $this->get_id() . "', '" . $this->get_user() .
            "', '" . $dissertation_id . "');";

        if ($connection->query($sql)) {
            return true;
        } else {
            echo $connection->error;
        }
    }

    function remove($dissertation_id)
    {
        include '../../src/mysql_login.php';
        session_start();

        $sql = "DELETE FROM user_dissertation_list_items WHERE dissertation_id='" . $dissertation_id .
            "' AND user='" . $_SESSION['user_id'] . "';";

        if ($connection->query($sql)) {
            return true;
        } else {
            echo $connection->error;
        }
    }

    function count_items()
    {
        return sizeof($this->items());
    }
}
