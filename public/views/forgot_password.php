<?php include 'header.php' ?>

<body>
    <?php include 'menu.php' ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <form class="login" action="../../src/auth/change_password_action.php" method="POST">
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Your Email" name="email" required>
                <button class="login" type="submit" name="send_reset_link">Send Password Reset Link</button>
            </form>
        </div>
    </div>

</body>

</html>