<?php
// PHPMailer namespace imports
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function notif_helper($recipient, $subject, $message, $attachment_path = null)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        // Use a fixed sender Gmail account
        $mail->Username   = 'ascanlindon@gmail.com';
        $mail->Password   = 'cuot mtcq vrwt ezwu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('ascanlindon@gmail.com', 'CraftsHub');
        $mail->addAddress($recipient);

        //Attachments
        if ($attachment_path !== null && file_exists($attachment_path)) {
            $mail->addAttachment($attachment_path);
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
