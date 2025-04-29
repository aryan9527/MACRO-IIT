<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Gadgest Deals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f6fa;
        }

        .navbar {
            background-color: #0d47a1;
            padding: 15px 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .navbar a:hover {
            color: #ffeb3b;
        }

        .welcome {
            padding: 30px;
            font-size: 22px;
            background: #e3f2fd;
            text-align: center;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
            padding: 40px 60px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .card h3 {
            margin: 10px 0 5px;
        }

        .card p {
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="welcome">
        👋 Welcome, <?php echo htmlspecialchars($username); ?> — Happy Shopping!
    </div>

    <div class="navbar">
        <a href="#">Home</a>
        <a href="#">Mobiles</a>
        <a href="#">Laptops</a>
        <a href="#">Audio</a>
        <a href="#">Accessories</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="products">
        <div class="card">
            <img src="images/mobile.jpg" alt="Mobile">
            <h3>Realme P1</h3>
            <p>From ₹14,999</p>
        </div>
        <div class="card">
            <img src="images/laptop.png" alt="Laptop">
            <h3>HP i5 Laptop</h3>
            <p>From ₹48,999</p>
        </div>
        <div class="card">
            <img src="images/headphones.jpg" alt="Headphones">
            <h3>JBL Headset</h3>
            <p>From ₹1,499</p>
        </div>
        <div class="card">
            <img src="images/speaker.png" alt="Speaker">
            <h3>boAt Stone 1200</h3>
            <p>From ₹2,999</p>
        </div>
        <div class="card">
            <img src="images/mouse.jpg" alt="Mouse">
            <h3>Logitech Mouse</h3>
            <p>From ₹799</p>
        </div>
        <div class="card">
            <img src="images/keyboard.jpg" alt="Keyboard">
            <h3>Gaming Keyboard</h3>
            <p>From ₹1,299</p>
        </div>
        <div class="card">
            <img src="images/charger.jpg" alt="Charger">
            <h3>Fast Charger</h3>
            <p>From ₹699</p>
        </div>
        <div class="card">
            <img src="images/earbud.jpg" alt="Earbuds">
            <h3>Noise Earbuds</h3>
            <p>From ₹2,199</p>
        </div>
    </div>

</body>
</html>
