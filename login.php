<?php
// Start output buffering and session
ob_start();
session_start();

// Error reporting ON
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db.php'; // Database connection

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Trim added here

    // Prepared statement to check if username exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set user session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            // Redirect without echo (important)
            header("Location: profile.php");
            exit();
        } else {
            echo "<div class='message'>❌ Invalid password.</div>";
        }
    } else {
        echo "<div class='message'>❌ User not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gadgest Deals</title>
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
            margin-top: 10px;
        }
    </style>
</head>
<body>

<form action="login.php" method="POST">
    <h2>Login</h2>
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>
