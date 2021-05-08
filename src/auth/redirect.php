<?php

session_start();

include '../../public/views/header.php';

if (!isset($_SESSION['user_id'])) {
    // If no user is logged in, redirect the user to the index.
    echo "<script>window.location = '../../public/views/index.php';</script>";
}
