<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = (float) $_POST['product_price']; // Ensuring price is treated as a number

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $already_added = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $product_name) {
            $item['quantity']++; // Increase quantity if already in cart
            $already_added = true;
            break;
        }
    }
    unset($item); // Important to unset reference in PHP

    if (!$already_added) {
        $_SESSION['cart'][] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
    }

    // Calculate total price after adding item
    $_SESSION['total_price'] = 0; // Reset total price
    foreach ($_SESSION['cart'] as $item) {
        $_SESSION['total_price'] += $item['price'] * $item['quantity'];
    }

    header("Location: cart.php");
    exit();
}
?>
