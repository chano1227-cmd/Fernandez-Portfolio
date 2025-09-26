<?php
session_start();
echo "<link rel='stylesheet' type='text/css' href='style.css'/>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crafty Hive</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    header .user-menu-container{
      font-size: 1.5rem;
      padding: 0 1.5rem; 
      color: #2d545e;
      font-weight: bold;
      justify-content: center;
      align-items: center;
    }

    .user-dropdown a {
      margin-right: 15px; 
    }

    .user-dropdown span {
      margin-right: 15px; 
    }

</style>
</head>

<body>
<header>
  <input type="checkbox" id="toggler">
  <label for="toggler" class="fas fa-bars"></label>

    <div class="logo-container">
      <img src="logo.png" alt="Crafty Hive Logo"> 
    </div>
     
    <nav class="navbar">
      <a href="#home">HOME</a>
      <a href="#about">ABOUT</a>
      <a href="#Collections">COLLECTIONS</a>
      <a href="booking.php">BOOK NOW</a>
    </nav>

    <div class="user-menu-container">
  <div class="user-dropdown" id="user-dropdown">
    <?php if (isset($_SESSION['u_fullname'])): ?>
      <span>Welcome, <?php echo $_SESSION['u_fullname']; ?>!</span>
      <a href="logout.php" style="margin-left: 10px;"><i class="fas fa-sign-out-alt"></i></a>
    <?php else: ?>
      <a href="login.php"><i class="fas fa-sign-in-alt"></i> </a>
      <a href="registration.php"><i class="fas fa-user-plus"></i> </a>
    <?php endif; ?>
  </div>
</div>
</header>
  
<section class="home" id="home">
    <div class="home-content">
        <h3>Crafty Hive!</h3>
        <span>for every occasions</span>
        <p>We offer a wide variety of floral arrangements for all types of occasions.</p>
        <button class="btn"> <a href="2ndpage.php">Shop</a></button>
    </div>
</section>

<section class="about" id="about"> 
    <h1 class="heading"><span> About </span> Us </h1>
    <div class="row">
        <div class="image-container">
        <img src="yellow.JPG" alt="Sunflower">
        <h3>Rising Bouquet Sellers</h3>
    </div>
        
    <div class="content">
        <h3>Why Choose Us?</h3>
        <p>At Crafty Hive, we take pride in creating stunning bouquet arrangements that go beyond traditional floral designs. <br>
        <br> Our unique approach combines the art of bouquet-making with a variety of materials, including delicious food items and beautifully handcrafted flowers. </br>
        <br> Whether you are celebrating a special occasion, expressing love, or simply brightening someone’s day, our arrangements are 
        thoughtfully tailored to bring joy and elegance to every moment. </p>
    </div>
</section>

<section class="Collections" id="Collections">
  <h1 class="heading"> Our <span> Collections </span></h1>
        
  <div class="box-container">
    <div class="box">
     <div class="image">
        <div class="flower-collection">
          <div class="collection-row">

            <div class="collection">
              <img src="yellow.JPG" alt="Collection 1">
                <div class="hover-content">
                  <p>Delight Bouquet</p>
                  <img src="yellow.JPG" alt="Collection 1">
                </div>
            </div>
                
            <div class="collection">
              <img src="blueee.JPG" alt="Collection 2">
                  <div class="hover-content">
                    <p>Azure Dreams Bouquet</p>
                    <img src="blueee.JPG" alt="Collection 2">
                  </div>
            </div>
    
            <div class="collection">
              <img src="Pink.JPG" alt="Collection 3">
                  <div class="hover-content">
                      <p>Pink Ombre Bouquet</p>
                      <img src="Pink.JPG" alt="Collection 3">
                  </div>
            </div>
    
            <div class="collection">
              <img src="rose.JPG" alt="Collection 4">
                  <div class="hover-content">
                      <p>Gentle Grace Bouquet</p>
                      <img src="rose.JPG" alt="Collection 4">
                  </div>
            </div>
    
            <div class="collection">
              <img src="red.JPG" alt="Collection 5">
                  <div class="hover-content">
                      <p>Classic Beauty Bouquet</p>
                      <img src="red.JPG" alt="Collection 5">
                  </div>
            </div>
    
            <div class="collection">
                <img src="tulip.JPG" alt="Collection 6">
                    <div class="hover-content">
                      <p>Tulip Delight Bouquet</p>
                      <img src="tulip.JPG" alt="Collection 6">
                    </div>
            </div>
        </div>   
</section>

<section class="footer">
  <div class="box-container">
    
        <div class="box">
            <h3>Quick Links</h3>
            <a href="#home">home</a>
            <a href="#about">About</a>
            <a href="#Collections">Collections</a>
            <a href="booking.php">Book Now</a>
        </div>
    
        <div class="box">
            <h3>Contact Information</h3>
            <p>09102511394</p>
            <a href="https://www.facebook.com/profile.php?id=100087202011432&mibextid=ZbWKwL">Facebook</a>
        </div>
    
        <div class="box">
            <h3>Location</h3>
            <p>Recodo, Zamboanga City, <br> Zamboanga Del Sur, Philippines</p>
        </div>
    
        <div class="box">
            <h3>Payment</h3>
            <p>GCash</p>
            <p>Cash on Delivery</p>
        </div>
    </div>
  
    <div class="credit"> Created by <span> Crafty Hive </span> | all rights reserved.</div>
</section>

    <script src="script.js"></script>
</body>
</html>