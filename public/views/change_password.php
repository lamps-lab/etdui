<?php
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
?>

<body>
    <?php include 'menu.php' ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <form class="login" action="../../src/auth/change_password_action.php" method="POST">
                <label for="current_password"><b>Current Password</b></label>
                <input type="password" placeholder="Enter Current Password" name="current_password" required>
                <label for="new_password"><b>New Password</b></label>
                <input type="password" placeholder="Enter New Password" name="new_password" required>
                <button class="login" type="submit" name="update_password">Update Password</button>
            </form>
        </div>
    </div>

</body>

</html>