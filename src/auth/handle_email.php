<?php

require_once '../../src/user.php';

require_once '../../vendor/autoload.php';
require_once '../../constants.php';


function initialize_mailer()
{
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername(EMAIL)
        ->setPassword(PASSWORD);

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    return $mailer;
}

function send_email($mailer, $sender, $receiver, $title, $body)
{
    // Create a message
    $message = (new Swift_Message($title))
        ->setFrom($sender)
        ->setTo($receiver)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);
}

if (isset($_SESSION['user_id'])) {

    function send_verification_email()
    {
        $user = new User();
        $user->query_by_id($_SESSION['user_id']);

        $mailer = initialize_mailer();

        $body = '<!DOCTYPE html>
                <html lang="en">
                
                <head>
                    <meta charset="UTF-8">
                    <title> Shields Search Verificaton</title>
                </head>
                
                <body>
                    <p> Thank you for signing up to Shields Search! Please click on the link
                        to verify your email!
                    </p>
                    <a href="http://localhost/Web-Programming/src/auth/verified.php?token=' . $user->get_token() . '">
                    Verify your email. </a>
                </body>
                
                </html>';

        $title = "Shields Search Account Email Verification";
        $sender = EMAIL;
        $receiver = $user->get_email();

        send_email($mailer, $sender, $receiver, $title, $body);
    }
}

function send_password_reset($email)
{
    $user = new User();
    $results = $user->query_by_email($email);

    while ($row = $results->fetch_assoc()) {
        $user->set_token($row['token']);
    }

    $mailer = initialize_mailer();

    $body = '<!DOCTYPE html>
                <html lang="en">
                
                <head>
                    <meta charset="UTF-8">
                    <title> Shields Search Password Reset</title>
                </head>
                
                <body>
                    <p> You are receiving this email because we received a
                        password reset request for your account.

                        If you did not request a password reset, no further
                        action is required.
                    </p>
                    <a href="http://localhost/Web-Programming/src/auth/reset_forgotten_password.php?token=' . $user->get_token() . '">
                    Reset Password. </a>
                </body>
                
                </html>';

    $title = "Shields Search Reset Password";
    $sender = EMAIL;
    $receiver = $email;

    send_email($mailer, $sender, $receiver, $title, $body);
}
