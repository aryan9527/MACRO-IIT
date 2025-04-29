<?php
session_start();

// Agar user login nahi hai toh login page pe redirect kar do
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Gadgest Deals</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #e8f5e9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .welcome-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2e7d32;
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            background: #388e3c;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        a.button:hover {
            background: #2e7d32;
        }
    </style>
</head>
<body>

<div class="welcome-box">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>! 👋</h1>
    <p>You have successfully logged in.</p>
    <a class="button" href="index.php">Open Gadgest Deals Homepage</a>
</div>

</body>
</html>
