<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';



// Correct relative path

function send_2fa_email($to, $code) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mysupermarket12@gmail.com'; // Your Gmail address
        $mail->Password = 'dpbl zuls tlnu psdm';        // App-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('mysupermarket12@gmail.com', 'My Supermarket'); // Must match $mail->Username
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body    = "Your 2FA verification code is <b>$code</b>";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}




