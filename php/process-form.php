<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require '../vendor/autoload.php'; // Make sure to require autoload.php from PHPMailer

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {

        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
            exit();
        }

        // Set your email address where you want to receive emails.
        $admin_email = 'imtiyaj7260@gmail.com';

        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                       // SMTP server for Gmail
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'imtiyaj7260@gmail.com';        // Your Gmail username
            $mail->Password = 'skok igia hikp fmgh';                  // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress($admin_email);                                    // Add a recipient

            // Content
            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'New Contact Form Submission: ' . $subject;
            $mail->Body = '<strong>Name:</strong> ' . $name . '<br>';
            $mail->Body .= '<strong>Email:</strong> ' . $email . '<br>';
            $mail->Body .= '<strong>Subject:</strong> ' . $subject . '<br>';
            $mail->Body .= '<strong>Message:</strong><br>' . nl2br($message);

            $mail->send();
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $mail->ErrorInfo]);
            exit();
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed. Use POST request.']);
    exit();
}
?>