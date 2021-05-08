<?php

require_once '../../src/user.php';

$user = new User();
$user->logout();

// Redirect user to the main page.
header("Location: ../../public/views/index.php");

?>
