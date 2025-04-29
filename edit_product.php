<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Optional: If you want to allow updating the image

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $price, $description, $image, $id);
    
    if ($stmt->execute()) {
        echo "Product updated successfully!";
        header("Location: product.php?id=" . $id);
        exit;
    } else {
        echo "Error updating product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      padding: 20px;
    }
    label {
      font-weight: bold;
      margin-top: 10px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Edit Product</h1>
  <form method="POST" action="">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" value="<?= $product['name'] ?>" required><br>

    <label for="price">Price:</label>
    <input type="text" name="price" id="price" value="<?= $product['price'] ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?= $product['description'] ?></textarea><br>

    <label for="image">Image URL:</label>
    <input type="text" name="image" id="image" value="<?= $product['image'] ?>"><br>

    <button type="submit">Update Product</button>
  </form>
</body>
</html>
