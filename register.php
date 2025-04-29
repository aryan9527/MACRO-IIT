<?php
// Error reporting ON
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['register'])) {
    // Collecting and sanitizing the user input
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $plain_password = $_POST['password'];

    // Hashing the password
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    include 'includes/db.php';  // Database connection

    // Check if the email or username already exists
    $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("ss", $email, $username);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "❌ User already exists. Please try a different email or username.";
    } else {
        // Inserting user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "❌ Registration failed: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gadgest Deals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #e3f2fd;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #0d47a1;
        }
        input {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            background: #0d47a1;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #1565c0;
        }
        .message {
            text-align: center;
            font-size: 16px;
            color: #d32f2f;
        }
    </style>
</head>
<body>

<form action="register.php" method="POST">
    <h2>Register</h2>
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit" name="register">Register</button>
</form>

</body>
</html>
