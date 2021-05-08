<?php
include '../../src/auth/redirect.php';
include 'header.php';
require_once '../../src/auth/handle_email.php';

// If the submit button is clicked, send the verification email.
if (isset($_POST['submit'])) {
    send_verification_email();
}

?>

<body>
    <?php include "menu.php" ?>

    <div class="flex-center position-ref full-height">
        <div class="card" style="width: 30rem;">
            <div class="card-header"> Send Verification </div>
            <div class="card-body content">
                Please check your email to receive the verification link.
                Your email must be verified to access this page.
                <br><br>
                <form action="" method="post">
                    <button class="login" name="submit">Resend Verification Link</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

</html>