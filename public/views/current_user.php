<?php

session_start();

require_once '../../src/user.php';

if (isset($_SESSION['user_id'])) {

    $user = new User();
    $user->query_by_id($_SESSION['user_id']);

    // Echo the user information in the card.
    echo "<div class='card-row'>";
    echo "<div class='card-subtitle'><b>Email:</b></div>";
    echo "<div class='card-text'>".$user->get_email()."</div></div>";
    echo "<br><br>";
    echo "<div class='card-row'>";
    echo "<div class='card-subtitle'><b>Username:</b></div>";
    echo "<div class='card-text'>".$user->get_name()."</div></div>";

}
