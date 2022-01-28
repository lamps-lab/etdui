<?php
session_start();
if (!isset($_SESSION['admin_access'])) {
    header('Location: ../../public/views/admin_access.php');
}
?>
<ul class="menu">
    <li class="menu"><a href="../../public/views/index.php">ETD Search Engine</a></li>
    <?php include '../../src/auth/logged_in.php'; ?>
</ul>