<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = "prafullagarasia@gmail.com";

    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["msg"] ?? ''));

    // Basic validation
    if (!$name || !$email || !$subject) {
        http_response_code(400);
        echo "Name, Email, and Subject are required.";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "<html><body>";
    $body .= "<h2>Contact Form Submission</h2>";
    $body .= "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
    $body .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    $body .= "<p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>";
    $body .= "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";
    $body .= "</body></html>";

    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo "Thank you for contacting us!";
    } else {
        http_response_code(500);
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
