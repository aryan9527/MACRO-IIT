<?php
include 'includes/db.php';

$newPassword = '123456'; // New password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


$username = 'piyush91';

$sql = "UPDATE users SET password = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hashedPassword, $username);
$stmt->execute();

echo "✅ Password reset ho gaya. Ab login karo with: <br>";
echo "Username: $username<br>";
echo "Password: $newPassword";
?>
