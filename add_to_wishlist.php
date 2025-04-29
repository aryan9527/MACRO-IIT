<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    if (!in_array($product_id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $product_id;
    }

    header("Location: wishlist.php");
    exit;
}
