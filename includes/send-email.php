<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
require __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
require __DIR__ . '/../config/env.php';

function sendBookingEmail($to, $subject, $html) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = getenv('BREVO_SMTP_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('BREVO_SMTP_USER');
        $mail->Password = getenv('BREVO_SMTP_PASS');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('BREVO_SMTP_PORT');

        $mail->setFrom(
            getenv('BREVO_FROM_EMAIL'),
            getenv('BREVO_FROM_NAME')
        );

        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}