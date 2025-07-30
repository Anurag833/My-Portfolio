<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// DB credentials
$host = "localhost";
$db = "contact_form_db";
$user = "root";
$pass = "";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Collect data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Save in database
$stmt = $conn->prepare("INSERT INTO messages (first_name, last_name, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $first_name, $last_name, $email, $message);
$stmt->execute();
$stmt->close();

// Send email using PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'xxxx'; // Your Gmail
    $mail->Password = 'xxxxx';   // Your Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Mail content
    $mail->setFrom('anuragpal.portfolio@gmail.com', 'Anurag');
    $mail->addAddress($email, $first_name);

    $mail->Subject = 'Thanks for contacting Anurag!';
    $mail->Body    = "Hi $first_name,\n\nThanks for reaching out!\nWe’ve received your message and will get back to you within 24–48 hours.\n\nRegards,\nAnurag";

    $mail->send();
    echo "<h2><center>Thank you! Your message has been submitted and a confirmation email has been sent.</center></h2>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
