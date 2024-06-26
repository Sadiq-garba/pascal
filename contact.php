<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure the path to autoload.php is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.example.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'your_email@example.com';               // SMTP username
            $mail->Password   = 'your_password';                        // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('your_email@example.com', 'Mailer');
            $mail->addAddress('recipient@example.com', 'Recipient Name');     // Add a recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "Name: $name<br>Email: $email<br>Message: $message";
            $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'All fields are required.';
    }
} else {
    echo 'Invalid request method.';
}
?>