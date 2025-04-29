<?php
// product.php
session_start();
require 'includes/db.php';

if (!isset($_GET['id'])) {
  echo "Product not found!";
  exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
  echo "Product not found!";
  exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> - Gadgest Deals</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
    }
    .product-detail {
      max-width: 800px;
      margin: auto;
      display: flex;
      gap: 40px;
    }
    .product-detail img {
      max-width: 350px;
      border-radius: 12px;
    }
    .info {
      flex: 1;
    }
    .info h1 {
      font-size: 28px;
      margin-bottom: 10px;
    }
    .info p {
      font-size: 16px;
    }
    .price {
      color: #ff6f61;
      font-weight: bold;
      font-size: 24px;
      margin: 15px 0;
    }
    .btn {
      padding: 12px 25px;
      background: #ff6f61;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: 600;
      border-radius: 8px;
    }
    .admin-actions {
      margin-top: 20px;
      display: flex;
      gap: 15px;
    }
    .admin-actions a {
      padding: 10px 20px;
      background: #333;
      color: white;
      border-radius: 8px;
      text-decoration: none;
    }
    .admin-actions a.edit {
      background: #f0ad4e;
    }
    .admin-actions a.delete {
      background: #d9534f;
    }
  </style>
</head>
<body>
  <div class="product-detail">
    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <div class="info">
      <h1><?= htmlspecialchars($product['name']) ?></h1>
      <p class="price">₹<?= htmlspecialchars($product['price']) ?></p>
      <p><?= htmlspecialchars($product['description']) ?></p>
      <form action="add_to_cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button class="btn" type="submit">Add to Cart</button>
      </form>
      
      <!-- Admin actions (only visible if admin is logged in) -->
      <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true): ?>
      <div class="admin-actions">
        <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit">Edit Product</a>
        <a href="delete_product.php?id=<?= $product['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
