<?php
session_start();

// Configuration
$to_email = "chhetrikarun6@gmail.com"; // Your email address
$subject = "New Contact Form Submission - My Business";

// Initialize variables
$errors = [];
$success = false;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required.";
    }
    
    // If no errors, proceed with sending email
    if (empty($errors)) {
        
        // Service options mapping
        $service_options = [
            'web-development' => '🌐 Web Development',
            'marketing' => '📈 Digital Marketing',
            'consulting' => '💼 Business Consulting',
            'other' => '🔧 Other'
        ];
        
        $selected_service = $service_options[$service] ?? 'Not specified';
        
        // Email content
        $email_content = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #0057b7; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #0057b7; }
                .value { margin-left: 10px; }
                .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Name:</span>
                        <span class='value'>" . htmlspecialchars($name) . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Email:</span>
                        <span class='value'>" . htmlspecialchars($email) . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Phone:</span>
                        <span class='value'>" . htmlspecialchars($phone ?: 'Not provided') . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Service Interest:</span>
                        <span class='value'>" . htmlspecialchars($selected_service) . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Message:</span>
                        <div style='margin-top: 10px; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 5px;'>
                            " . nl2br(htmlspecialchars($message)) . "
                        </div>
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent from your business website contact form.</p>
                    <p>Submitted on: " . date('Y-m-d H:i:s') . "</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Email headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $email,
            'Reply-To: ' . $email,
            'Return-Path: ' . $email,
            'X-Mailer: PHP/' . phpversion()
        ];
        
        // Attempt to send email
        $mail_sent = mail($to_email, $subject, $email_content, implode("\r\n", $headers));
        
        if ($mail_sent) {
            $_SESSION['success_message'] = "Thank you for your message! We'll get back to you soon.";
            $success = true;
            
            // Optional: Save to database (uncomment if you want to store submissions)
            // saveToDatabase($name, $email, $phone, $service, $message);
            
        } else {
            $errors[] = "Sorry, there was an error sending your message. Please try again or contact us directly.";
        }
    }
    
    // Store errors in session
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
    }
    
    // Redirect back to the main page
    header("Location: index.php#contact");
    exit;
} else {
    // If someone tries to access this file directly
    header("Location: index.php");
    exit;
}

// Optional: Database storage function
function saveToDatabase($name, $email, $phone, $service, $message) {
    // Database configuration
    $host = 'localhost';
    $dbname = 'your_database_name';
    $username = 'your_db_username';
    $password = 'your_db_password';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO contact_submissions (name, email, phone, service, message, submitted_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone, $service, $message]);
        
    } catch (PDOException $e) {
        // Log error (don't show to user)
        error_log("Database error: " . $e->getMessage());
    }
}
?>