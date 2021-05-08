<?php
require_once '../user.php';

$verified_body = '<body>
<?php include "../../public/views/menu.php" ?>

<div class="flex-center position-ref full-height">
    <div class="card" style="width: 30rem;">
        <div class="card-header"> Verification Status</div>
        <div class="card-body" style="color: green;">
            Your account is now verified!
        </div>
    </div>
</div>
</body>

</html>';

$not_verified = '<body>
<?php include "../../public/views/menu.php" ?>

<div class="flex-center position-ref full-height">
    <div class="card" style="width: 30rem;">
        <div class="card-header"> Verification Status</div>
        <div class="card-body" style="color: red;">
            Your account could not be verified, please try again.
        </div>
    </div>
</div>
</body>

</html>';

if (isset($_GET['token'])) {
    // Get the token from the URL.
    $token = $_GET['token'];

    $user = new User();

    if ($user->verify($token)) {
        // If the verification was successful, inform the user.
        include '../../public/views/header.php';
        echo $verified_body;
    } else {
        // If the verification failed, inform the user.
        include '../../public/views/header.php';
        echo $not_verified;
    }
} else {
    include '../../public/views/header.php';
    echo $not_verified;
}
