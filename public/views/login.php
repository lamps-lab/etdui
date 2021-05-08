<?php include 'header.php' ?>

<body>
    <?php
     include 'menu.php';
     include '../../constants.php';
     ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <form class="login" id="login-form" method="POST">
                <label for="email"><b>Email</b></label>
                <p class="error" id="email-error" hidden></p>
                <input type="text" placeholder="Enter Email" id="email" name="email" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" id="password" name="password" required>
                <p class="error" id="password-error" hidden></p>
                <button class="login" type="button" name="submit" onclick="logIn()">Login</button>
                <div class="g-recaptcha flex-center" style="margin-top: 15px;" data-sitekey=<?php echo SITE_KEY ?>></div>
                <p class="error" id="recaptcha-error" hidden> Please prove that you are not a robot. </p>
            </form>
            <br>
            <p>Haven't registered yet? <a href="registration.php">Sign Up Here.</a> </p>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
    <script src="../js/auth.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>