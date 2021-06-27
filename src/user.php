<?php

class User
{

    // Properties
    private $id;
    private $email;
    private $name;
    private $hashed_password;
    private $verified;
    private $token;

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function set_email($email)
    {
        $this->email = $email;
    }

    function get_email()
    {
        return $this->email;
    }

    function set_name($name)
    {
        $this->name = $name;
    }

    function get_name()
    {
        return $this->name;
    }

    function set_hashed_password($hashed_password)
    {
        $this->hashed_password = $hashed_password;
    }

    function get_hashed_password()
    {
        return $this->hashed_password;
    }

    function set_verified($verified)
    {
        $this->verified = $verified;
    }

    function get_verified()
    {
        return $this->verified;
    }

    function set_token($token)
    {
        $this->token = $token;
    }

    function get_token()
    {
        return $this->token;
    }

    function query_by_email($entered_email)
    {
        include 'mysql_login.php';

        // Query for the email entered in the user database.
        $query = "SELECT * FROM users WHERE email='" . $entered_email . "';";
        $results = $connection->query($query);

        return $results;
    }

    function query_by_id($entered_id)
    {
        include 'mysql_login.php';

        // Query for the id entered in the user database.
        $query = "SELECT * FROM users WHERE id='" . $entered_id . "';";
        $results = $connection->query($query);

        while ($row = $results->fetch_assoc()) {

            // Set all of the user attributes.
            $this->set_id($row['id']);
            $this->set_email($row['email']);
            $this->set_name($row['username']);
            $this->set_hashed_password($row['hashedpassword']);
            $this->set_verified($row['verified']);
            $this->set_token($row['token']);
        }
    }

    function query_by_token($entered_token)
    {
        include 'mysql_login.php';

        // Query the user by token.
        $query = "SELECT * FROM users WHERE token='" . $entered_token . "'LIMIT 1;";
        $result = $connection->query($query);

        return $result;
    }

    function email_used($entered_email)
    {

        $results = $this->query_by_email($entered_email);

        if ($results->num_rows > 0) {
            // If the email is found in the database, return true.
            return true;
        } else {
            // If the email is not found in the database, return false.
            return false;
        }
    }

    function name_used($entered_name)
    {
        include 'mysql_login.php';

        $query = "SELECT * FROM users WHERE username='" . $entered_name . "';";
        $results = $connection->query($query);

        if ($results->num_rows > 0) {
            // If the username is found in the database, return true.
            return true;
        } else {
            // If the username is not found in the database, return false.
            return false;
        }
    }

    function register($entered_email, $entered_name, $entered_password)
    {
        include 'mysql_login.php';

        session_start();

        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        $sql = "INSERT INTO users (email, username, hashedpassword, verified, token) VALUES ('" . $entered_email . "', '" .
            $entered_name . "', '" . $entered_password . "', FALSE, '" . $token . "');";

        if ($connection->query($sql) === true) {
            // Start the user's session.
            $results = $this->query_by_email($entered_email);

            while ($row = $results->fetch_assoc()) {
                $this->set_id($row['id']);
            }

            $_SESSION['user_id'] = $this->get_id();

            require_once 'auth/handle_email.php';

            send_verification_email();

            return true;
        } else {
            return false;
        }
    }

    function verify($entered_token)
    {
        include 'mysql_login.php';

        if (!empty($this->query_by_token($entered_token))) {
            // If a user does have that token, change their account to verified.
            $sql = "UPDATE users SET verified='1' WHERE token='" . $entered_token . "';";

            if ($connection->query($sql) === true) {
                return true;
            } else {
                return false;
            }
        }
    }

    function login($entered_email, $entered_password)
    {
        session_start();

        $results = $this->query_by_email($entered_email);

        while ($row = $results->fetch_assoc()) {

            // Set user ID.
            $this->set_id($row["id"]);

            // Set the hashed password.
            $hashed_password = $row["hashedpassword"];

            if (password_verify($entered_password, $hashed_password)) {
                // If the hashed password is verified as the hash of
                // the plain password, set the session ID as the user's
                // ID.
                $_SESSION['user_id'] = $this->get_id();

                return true;
            } else {
                return false;
            }
        }
    }

    function logout()
    {
        session_start();
        // Unset the session variables.
        unset($_SESSION['user_id']);
        // Destroy the session.
        session_destroy();
    }

    function change_username($new_name)
    {
        include 'mysql_login.php';

        // Update the users username with the newly entered username.
        $sql = "UPDATE users SET username='" . $new_name . "' WHERE id='" . $this->get_id() . "';";

        if ($connection->query($sql) === true) {
            return true;
        } else {
            return false;
        }
    }

    function change_password($new_hashed_password)
    {
        include 'mysql_login.php';

        // Update the users password with the newly entered password.

        $sql = "UPDATE users SET hashedpassword='" . $new_hashed_password . "' WHERE id='" . $this->get_id() . "';";
        if ($connection->query($sql) === true) {
            return true;
        } else {
            return false;
        }
    }
}
