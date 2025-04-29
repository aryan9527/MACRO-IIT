<?php
session_start();
include('includes/db.php');

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

$order_confirmed = false;
$discount = 0; // Default discount is 0

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method']; // Cash on Delivery or PayPal
    $coupon_code = $_POST['coupon_code']; // Get the coupon code entered by the user

    // ✅ Check and apply discount if valid coupon is provided
    if (!empty($coupon_code)) {
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ?");
        $stmt->bind_param("s", $coupon_code);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $coupon = $result->fetch_assoc();
            $discount = $coupon['discount']; // Apply the discount percentage
        } else {
            $coupon_error = "Invalid coupon code.";
        }
    }

    // ✅ Calculate total first
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Apply discount to total
    $total_after_discount = $total - ($total * $discount / 100);

    // ✅ Prepare order insert
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, phone, total_price, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssds", $name, $email, $address, $phone, $total_after_discount, $payment_method);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Using the inserted ID as order_id

        // ✅ Insert each cart item into order_items
        foreach ($_SESSION['cart'] as $item) {
            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
            $stmt_item->bind_param("isdi", $order_id, $item['name'], $item['price'], $item['quantity']);
            $stmt_item->execute();
        }

        // Clear cart after order
        unset($_SESSION['cart']);

        // Redirect to order confirmation page
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Order failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Gadgest Deals</title>
    <style>
        /* Your existing styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 15px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            background-color: #2e7d32;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #1b5e20;
        }

        .paypal-button {
            margin-top: 20px;
            display: none; /* Initially hide PayPal button */
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script>
</head>
<body>

    <h2>Checkout</h2>

    <form action="checkout.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method" required>
            <option value="cash_on_delivery">Cash on Delivery</option>
            <option value="paypal">PayPal</option>
        </select>

        <!-- Coupon Code Input -->
        <label for="coupon_code">Coupon Code (If any):</label>
        <input type="text" id="coupon_code" name="coupon_code" placeholder="Enter coupon code">
        
        <!-- Error Message for Invalid Coupon -->
        <?php if (!empty($coupon_error)) { echo '<p class="error-message">' . $coupon_error . '</p>'; } ?>

        <button type="submit" id="place-order-btn">Place Order</button>
    </form>

    <!-- PayPal Button Integration -->
    <div id="paypal-button-container" class="paypal-button"></div>

    <script>
        // Show PayPal button if PayPal is selected
        const paymentMethodSelect = document.getElementById('payment_method');
        const paypalButtonContainer = document.getElementById('paypal-button-container');
        const placeOrderBtn = document.getElementById('place-order-btn');

        paymentMethodSelect.addEventListener('change', function() {
            if (paymentMethodSelect.value === 'paypal') {
                paypalButtonContainer.style.display = 'block'; // Show PayPal button
                placeOrderBtn.style.display = 'none'; // Hide "Place Order" button
            } else {
                paypalButtonContainer.style.display = 'none'; // Hide PayPal button
                placeOrderBtn.style.display = 'block'; // Show "Place Order" button
            }
        });

        // PayPal button for online payment
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total_after_discount; ?>' // Pass the total order amount here
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Payment successful for ' + details.payer.name.given_name);
                    window.location.href = "order_confirmation.php?order_id=<?php echo $order_id; ?>";
                });
            }
        }).render('#paypal-button-container'); // Display PayPal button
    </script>

</body>
</html>
