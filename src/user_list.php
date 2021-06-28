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

    /**
     * Checks if dissertation is in the list.
     */
    function in_list($dissertation_id)
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_dissertation_list_items WHERE list='" . $this->get_id() .
            "' AND dissertation_id='" . $dissertation_id . "';";

        $result = $connection->query($query);

        return ($result->num_rows > 0);
    }

    /**
     * Creates list for the dissertation.
     */
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

    /**
     * Gets all of the items in list of dissertations.
     */
    function items()
    {
        include '../../src/mysql_login.php';

        $query = "SELECT * FROM user_dissertation_list_items WHERE user='" . $this->get_user() .
            "' AND list='" . $this->get_id() . "';";

        return $connection->query($query);
    }


    /**
     * Deletes the from the user's list of dissertations.
     */
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

    /**
     * Deletes all of the lists by a user.
     */
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

    /**
     * Adds a new dissertation to a list.
     */
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

    /**
     * Removes a dissertation from a list.
     */
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

    /**
     * Returns the number of items in the list of dissertations.
     */
    function count_items()
    {
        return sizeof($this->items());
    }
}
