<?php
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect input
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!$first_name || !$last_name || !$gender || !$number || !$address || !$email || !$password) {
        $message = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!preg_match('/^\d+$/', $number)) {
        $message = "Phone number must contain digits only.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB using prepared statements
        $stmt = $conn->prepare("INSERT INTO demo (first_name, last_name, gender, number, address, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $last_name, $gender, $number, $address, $email, $hashed_password);

        if ($stmt->execute()) {
            // Success — redirect or show message
            header("Location: login.php?msg=registered");
            exit;
        } else {
            if ($conn->errno === 1062) { // Duplicate entry error code
                $message = "Email or phone number already registered.";
            } else {
                $message = "Error: " . $conn->error;
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="Signup">
        <h1>Signup</h1>
        <h4>It's free and only takes a minute</h4>

        <?php if ($message): ?>
            <p style="color:red; text-align:center;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>First Name</label>
            <input type="text" name="first_name" required>

            <label>Last Name</label>
            <input type="text" name="last_name" required>

            <label>Gender</label>
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Number</label>
            <input type="tel" name="number" required pattern="\d+" title="Digits only">

            <label>Address</label>
            <input type="text" name="address" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required minlength="6">

            <input type="submit" value="Sign Up">
        </form>

        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</body>
</html>
