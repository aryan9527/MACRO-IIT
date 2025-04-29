<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gadgest Deals</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3771/3771560.png">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <!-- Link to external CSS -->

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #fff;
      color: #333;
      transition: background 0.3s, color 0.3s;
    }

    body.dark-mode {
      background: #121212;
      color: #fff;
    }

    header {
      background: #27ae60;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 600;
      color: white;
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 40px;
      margin-right: 10px;
      filter: brightness(0) invert(1);
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 30px;
      flex-wrap: wrap;
    }

    nav li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    nav li a:hover {
      color: #ffd700;
    }

    .toggle-mode {
      background: transparent;
      border: none;
      font-size: 20px;
      color: white;
      cursor: pointer;
    }

    .search-bar {
      width: 80%;
      max-width: 500px;
      background-color: white;
      padding: 10px 15px;
      border-radius: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin: 30px auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .search-bar input {
      width: 80%;
      padding: 10px;
      border: none;
      outline: none;
    }

    .search-bar button {
      background-color: #27ae60;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 10px 15px;
      cursor: pointer;
    }

    .hero-section {
      background: url('https://images.unsplash.com/photo-1580910051073-b7e899fe5c4c') no-repeat center center/cover;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
    }

    .hero-content {
      background: rgba(0,0,0,0.5);
      padding: 30px;
      border-radius: 16px;
    }

    .hero-content h1 {
      font-size: 36px;
      margin-bottom: 10px;
    }

    .hero-content p {
      font-size: 18px;
    }

    .hero-button {
      background: #ff6f61;
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 15px;
      display: inline-block;
    }

    main {
      padding: 40px 20px;
      max-width: 1400px;
      margin: auto;
    }

    .filter-bar {
      margin-bottom: 20px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .filter-bar select {
      padding: 8px;
      border-radius: 8px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
    }

    .product-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: 0.3s;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .product-card .info {
      padding: 15px;
    }

    .product-card h4 {
      margin-bottom: 10px;
    }

    .product-card form {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .product-card form button {
      flex: 1;
      background: #27ae60;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px;
      cursor: pointer;
    }

    .product-card form button:hover {
      opacity: 0.9;
    }

    body.dark-mode header {
      background: #1e1e1e;
    }

    body.dark-mode .product-card {
      background: #1e1e1e;
      color: white;
    }

    .hamburger {
  display: none;
  flex-direction: column;
  cursor: pointer;
}

.hamburger span {
  width: 25px;
  height: 3px;
  background: white;
  margin: 4px 0;
}

@media (max-width: 768px) {
  nav ul {
    display: none;
    flex-direction: column;
    width: 100%;
    background: #27ae60;
    padding: 10px;
  }

  nav ul.active {
    display: flex;
  }

  .hamburger {
    display: flex;
  }

  .search-bar {
    width: 90%;
    margin: 20px auto;
  }
}


    
  </style>
</head>
<body>
<header>
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/3771/3771560.png" alt="Logo">
      Gadgest Deals
    </div>

    <!-- Hamburger Menu Icon -->
    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- Navbar -->
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Laptops</a></li>
        <li><a href="#">Smartphones</a></li>
        <li><a href="#">TVs</a></li>
        <li><a href="#">Cameras</a></li>
        <li><a href="#">Speakers</a></li>
        <li>
          <a href="cart.php" style="position: relative;">
            🛒 Cart
            <span style="position: absolute; top: -8px; right: -15px; background: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 50%;">
              <?php echo $cart_count; ?>
            </span>
          </a>
        </li>
        <li><a href="#">👤Profile</a></li>
      </ul>
    </nav>

    <!-- Dark Mode Toggle -->
    <button class="toggle-mode" onclick="toggleMode()">🌙</button>

    <!-- Search Bar -->
    <div class="search-bar">
      <input type="text" placeholder="Search products...">
      <button>Search</button>
    </div>
</header>

<!-- JavaScript for Hamburger Toggle -->
<script>
  function toggleMenu() {
    const navbar = document.querySelector('nav');
    navbar.classList.toggle('active');
  }
</script>


  <section class="hero-section">
    <div class="hero-content">
      <h1>Upgrade Your Gadgets Today!</h1>
      <p>Best deals on laptops, smartphones, TVs & more</p>
      <a href="#products" class="hero-button">Explore Deals</a>
    </div>
    
  </section>

  <main id="products">
    <div class="filter-bar">
      <label for="category">Filter:</label>
      <select id="category" onchange="filterProducts()">
        <option value="all">All</option>
        <option value="laptops">Laptops</option>
        <option value="smartphones">Smartphones</option>
        <option value="tvs">TVs</option>
        <option value="camera">Camera</option>
        <option value="speakers">Speakers</option>
      </select>
    </div>

    <div class="product-grid">
      <?php
      $products = [
        ["HP Pavilion 15", "59999", "laptops", "https://m.media-amazon.com/images/I/71YqSAgKL7L._AC_UY218_.jpg"],
        ["Dell Inspiron 14", "52999", "laptops", "https://m.media-amazon.com/images/I/71sqpJ3MbxL._AC_UY218_.jpg"],
        ["Samsung Galaxy S21", "48999", "smartphones", "https://m.media-amazon.com/images/I/81vqHyDCSCL._AC_UY218_.jpg"],
        ["iPhone 13", "69999", "smartphones", "https://m.media-amazon.com/images/I/61l9ppRIiqL._AC_UY218_.jpg"],
        ["Sony Bravia 55", "75999", "tvs", "https://m.media-amazon.com/images/I/81h-r-3hioL._AC_UY218_.jpg"],
        ["Canon EOS 1500D", "42999", "camera", "https://m.media-amazon.com/images/I/914hFeTU2-L._SL1500_.jpg"],
        ["JBL Flip 5", "8499", "speakers", "https://m.media-amazon.com/images/I/71xKmsQ9XsL._AC_UY218_.jpg"]
      ];
      for ($i = 0; $i < 20; $i++) {
        $p = $products[$i % count($products)];
        echo '<div class="product-card" data-category="' . $p[2] . '">
                <img src="' . $p[3] . '" alt="' . $p[0] . '">
                <div class="info">
                  <h4>' . $p[0] . '</h4>
                  <p>₹' . number_format($p[1]) . '</p>

                  <form method="post" action="add_to_cart.php">
  <input type="hidden" name="product_name" value="' . $p[0] . '">
  <input type="hidden" name="product_price" value="' . $p[1] . '"> <!-- ✅ Fixed -->
  <button type="submit">Add to Cart</button>
  <a href="product-details.php?id=1" style="text-align:center; background:#27ae60; color:white; padding:8px 10px; border-radius:8px; text-decoration:none;">View Details</a>
 
</form>

                </div>
              </div>';
      }
      
      ?>
    </div>
    
  </main>

  <script>
    // dark mode taggol
    function toggleMode() {
      document.body.classList.toggle('dark-mode');
    }

   
    function filterProducts() {
      const category = document.getElementById('category').value;
      const cards = document.querySelectorAll('.product-card');

      cards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        if (category === 'all' || category === cardCategory) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }

   
    document.querySelector('.search-bar button').addEventListener('click', () => {
      const query = document.querySelector('.search-bar input').value.toLowerCase();
      const cards = document.querySelectorAll('.product-card');

      cards.forEach(card => {
        const title = card.querySelector('h4').innerText.toLowerCase();
        if (title.includes(query)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });

   
    function toggleMenu() {
      const nav = document.querySelector('nav ul');
      nav.classList.toggle('active');
    }
  </script>


<footer style="background-color: #1e7e34; color: white; padding: 20px 10px;  bottom: 0; width: 100%; z-index: 999;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        <!-- Left Section -->
        <div style="flex: 1; min-width: 200px;">
            <h3 style="margin: 0; font-size: 18px;">📞 +91-95279 50988</h3>
            <p style="margin: 5px 0;">📧 support@gadgestdeals.com</p>
        </div>

        <!-- Center Section -->
        <div style="flex: 1; text-align: center; min-width: 200px;">
            <p style="margin: 0;">© 2025 <strong>Gadgest Deals</strong></p>
            <a href="#" style="color: white; text-decoration: none;">Privacy Policy</a>
        </div>

        <!-- Right Section -->
        <div style="flex: 1; min-width: 200px; text-align: right;">
            <a href="https://facebook.com" style="color: white; margin-right: 10px;">Facebook</a>
            <a href="https://twitter.com" style="color: white; margin-right: 10px;">Twitter</a>
            <a href="https://instagram.com" style="color: white;">Instagram</a>
        </div>
    </div>
</footer>


</body>
</html>
