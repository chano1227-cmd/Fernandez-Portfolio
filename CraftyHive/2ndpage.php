<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CraftyHive Shop</title>
  <link rel="stylesheet" href="2ndStyle.css" />
  <style>

  .logo{
    position: absolute;
    left: 30px; 
    justify-content: left;
  }

  .logo img{
    width: 50px; 
    height: 50px; 
    margin-top: 10px;
    border-radius: 50%; 
    object-fit: cover; 
  }

  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo.png" alt="Logo" class="logo" />
    </div>
    
    <div class="categories">
      <a href="index.php">Home</a>
      <a href="index.php">About</a>
      <a href="booking.php">Book Now</a>
      <a href="index.php">Contact Us</a>
    </div>
  </header>

  <section class="products">
    <h2>Our Bouquets</h2>
    <div class="product-list">
      <!-- Product 1 -->
      <div class="product">
        <img src="blue.JPG" alt="blue" />
        <h3>Pink Ombre Bouquet</h3>
        <p>Price: ₱2000.00</p>
      </div>

      <!-- Product 2 -->
      <div class="product">
        <img src="yellow.JPG" alt="yellow" />
        <h3>Sun-Drenched Delight Bouquet</h3>
        <p>Price: ₱1000.00</p>
      </div>

      <!-- Product 3 -->
      <div class="product">
        <img src="blueee.JPG" alt="blueee" />
        <h3>Azure Dreams Bouquet</h3>
        <p>Price: ₱2000.00</p>
      </div>

      <!-- Product 4 -->
      <div class="product">
        <img src="rose.JPG" alt="rose" />
        <h3>Gentle Grace Bouquet</h3>
        <p>Price: ₱1500.00</p>
      </div>

      <!-- Product 5 -->
      <div class="product">
        <img src="red.JPG" alt="red" />
        <h3>Classic Beauty Bouquet</h3>
        <p>Price: ₱1500.00</p>
      </div>

      <!-- Product 6 -->
      <div class="product">
        <img src="tulip.JPG" alt="tulip" />
        <h3>Tulip Delight Bouquet</h3>
        <p>Price: ₱1000.00</p>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Crafty Hive.</p>
  </footer>

</body>
</html>
</attempt_completion>
