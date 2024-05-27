<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure to require autoload.php from PHPMailer

if (isset($_REQUEST['name'], $_REQUEST['email'])) {

    $name = $_REQUEST['name'];
    $mail = $_REQUEST['email'];
    $subject = $_REQUEST['subject'];
    $message = $_REQUEST['message'];

    // Set your email address where you want to receive emails.
    $to = 'imtiyaj7260@gmail.com';

    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                       // SMTP server for Gmail
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'mdimtiyaj22062002@gmail.com';        // Your Gmail username
        $mail->Password = 'mcdv juvx siyk cyyw';                  // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($mail->Username, $name);
        $mail->addAddress($to);                                    // Add a recipient

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "error: {$mail->ErrorInfo}";
    }

}
?>