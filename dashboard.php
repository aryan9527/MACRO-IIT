<?php
session_start();
include 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch user details from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gadgest Deals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0d47a1;
        }
        .user-info {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
        }
        .user-info p {
            margin: 5px 0;
        }
        .logout-btn {
            background: #0d47a1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
        .logout-btn:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Dashboard, <?= htmlspecialchars($user['username']) ?>!</h2>
        
        <div class="user-info">
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
