<?php

session_start();

require_once '../../src/user.php';

$user = new User();
$user->query_by_id($_SESSION['user_id']);


if ($user->get_verified() == 0) {
    // If user is not verified, redirect user to resend verification page.
    echo "<script>window.location = '../../public/views/resend_verification.php';</script>";
}
