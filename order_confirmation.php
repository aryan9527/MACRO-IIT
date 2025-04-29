<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/db.php');

// Get the order_id from the URL
if (!isset($_GET['order_id'])) {
    die("Order ID not provided");
}

$order_id = $_GET['order_id'];

// Prepare SQL query to fetch the order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameter for the prepared statement
$stmt->bind_param("i", $order_id);
if ($stmt === false) {
    die("Error binding parameters: " . $stmt->error);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    die("Order not found");
}

// Fetching products for the current order
$stmt_items = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Gadgest Deals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        .order-details {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 600px;
        }

        .order-details table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .order-details th, .order-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .order-details th {
            background-color: #2e7d32;
            color: white;
        }

        .order-summary {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <h2>Order Confirmation</h2>

    <div class="order-details">
        <h3>Order Details</h3>
        <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $order['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
        <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
        <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
        <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>

        <h3>Products Ordered</h3>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php while ($item = $result_items->fetch_assoc()): ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="order-summary">
            <p><strong>Total Price:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
        </div>
    </div>

</body>
</html>
