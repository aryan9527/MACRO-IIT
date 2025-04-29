<?php
session_start();

// Add product to wishlist
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // If wishlist doesn't exist, initialize it
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    // Add product to wishlist
    if (!in_array($product_id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $product_id;
    } else {
        // Remove product from wishlist if already there
        $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$product_id]);
    }
}
?>
