<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$total = 0;

// Handle quantity update (increment/decrement)
if (isset($_POST['update_quantity'])) {
    $index = $_POST['index'];
    if ($_POST['update_quantity'] === 'increment') {
        $_SESSION['cart'][$index]['quantity'] += 1;
    } elseif ($_POST['update_quantity'] === 'decrement') {
        if ($_SESSION['cart'][$index]['quantity'] > 1) {
            $_SESSION['cart'][$index]['quantity'] -= 1;
        }
    } else {
        $quantity = $_POST['quantity'];
        if ($quantity > 0) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }
}

// Handle item removal
if (isset($_POST['remove_item'])) {
    $index = $_POST['index'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
}

// Update the cart after any session change
$cart = $_SESSION['cart'];

// Calculate total price
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Gadgest Deals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #27ae60;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #27ae60;
            color: white;
        }

        td img {
            height: 60px;
            border-radius: 8px;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-control input {
            width: 50px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .quantity-control button {
            background: #27ae60;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 6px;
        }

        .quantity-control button:hover {
            background: #219150;
        }

        .total-price {
            font-size: 1.4rem;
            font-weight: 600;
            color: #27ae60;
            margin-top: 20px;
            text-align: right;
        }

        .checkout-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
            width: 100%;
        }

        .checkout-btn:hover {
            background: #219150;
        }

        .empty-msg {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }

        @media (max-width: 600px) {
            .checkout-btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Your Cart</h1>

        <?php if (empty($cart)): ?>
            <p class="empty-msg">Your cart is currently empty 😢</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart as $index => $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>₹<?= number_format($item['price']) ?></td>
                        <td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <div class="quantity-control">
                                    <button type="submit" name="update_quantity" value="decrement">-</button>
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                    <button type="submit" name="update_quantity" value="increment">+</button>
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="cart.php" style="margin:0;">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button class="remove-btn" type="submit" name="remove_item">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="total-price">
                Total: ₹<?= number_format($total) ?>
            </div>

            <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        <?php endif; ?>

        <a href="logout.php" class="logout-btn">Logout</a>

    </div>

    <style>
        .logout-btn {
            color: white;
            background: #219150;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:hover {
            background:rgb(36, 114, 68);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</body>
</html>
