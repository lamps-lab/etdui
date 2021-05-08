<?php
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
?>

<body>
    <?php include 'menu.php' ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <form class="login" action="../../src/auth/change_username_action.php" method="POST">
                <label for="username"><b>New Username</b></label>
                <input type="text" placeholder="Enter New Username" name="username" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <button class="login" type="submit">Update Username</button>
            </form>
        </div>
    </div>

</body>

</html>