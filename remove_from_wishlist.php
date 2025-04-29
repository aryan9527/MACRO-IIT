<?php
// Include database connection
include('include/db.php');

// Start session to track user login
session_start();

// Check if product ID is passed
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];  // Get logged-in user's ID

        // Delete product from wishlist
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        // Redirect back to wishlist page
        header("Location: wishlist.php");
        exit;
    } else {
        echo "Please log in to remove items from your wishlist.";
    }
} else {
    echo "No product ID found.";
}
?>
