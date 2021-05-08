<?php 
include 'header.php';
include '../../constants.php'; 
?>

<body>
    <?php include 'menu.php' ?>

    <div class="flex-center position-ref full-height">
        <div class="content">
            <form class="login" id="registration" action="../../src/auth/registration_action.php" method="POST" onsubmit="validateRegistration()">
                <div class="container">
                    <label for="email"><b>Email*</b></label>
                    <p class="error" id="email-error" hidden></p>
                    <input type="text" placeholder="Enter Email" name="email" id="email" required>
                </div>
                <div class="container">
                    <label for="username"><b>Username*</b></label>
                    <p class="error" id="username-error"></p>
                    <input type="text" placeholder="Enter Username" name="username" id="username" required>
                </div>
                <div class="container">
                    <label for="password"><b>Password*</b></label>
                    <p class="error" id="password-error"></p>
                    <input type="password" placeholder="Enter Password" name="password" id="password" required>
                </div>
                <div class="container">
                    <label for="confirm_password"><b>Confirm Password*</b></label>
                    <p class="error" id="confirm-password-error"></p>
                    <input type="password" placeholder="Retype Password" name="confirm_password" id="confirm_password" required>
                </div>
                <button class="login" type="button" name="submit" onclick="registration()">Sign Up</button>
                <div class="g-recaptcha flex-center" style="margin-top: 15px;" data-sitekey=<?php echo SITE_KEY ?>></div>
                <p class="error" id="recaptcha-error" hidden> Please prove that you are not a robot. </p>
            </form>
            <br>
            <p>Already signed up? <a href="login.php">Log In Here.</a>
        </div>
    </div>

    <script src="../js/auth.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>