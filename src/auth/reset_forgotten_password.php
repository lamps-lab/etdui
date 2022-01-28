<?php

require_once '../user.php';

if (isset($_GET['token'])) {

    $body = '<body>
                <?php include "../../public/views/menu.php" ?>
                <div class="flex-center position-ref full-height">
                    <div class="content">
                        <form class="login" action="" method="POST">
                            <label for="new_password"><b>New Password</b></label>
                            <input type="password" placeholder="Enter New Password" name="new_password" required>
                            <button class="login" type="submit" name="enter_password">Reset Password</button>
                        </form>
                    </div>
                </div>
            </body>
        </html>';

    $token = $_GET['token'];

    $user = new User();
    $results = $user->query_by_token($token);

    while ($row = $results->fetch_assoc()) {
        $user->set_id($row['id']);
    }

    if (isset($_POST['enter_password'])) {

        $new_password = "";

        if (isset($_POST['new_password'])) {
            $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        }

        if ($user->change_password($new_password)) {

            $body =  '<body>
                        <?php include "../../public/views/menu.php" ?>
                        
                        <div class="flex-center position-ref full-height">
                            <div class="card" style="width: 30rem;">
                                <div class="card-header"> Password Reset Status</div>
                                <div class="card-body" style="color: green;">
                                    Your password has been successfully reset.
                                </div>
                            </div>
                        </div>
                        </body>
                        
                        </html>';
        }
    }

    include '../../public/views/header.php';
    echo $body;
}
