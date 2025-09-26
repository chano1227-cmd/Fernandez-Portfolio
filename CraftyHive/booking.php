<?php
session_start();

if (!isset($_SESSION['u_fullname'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "craftyHive";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

// Only process form if submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_SESSION['u_fullname'];
  $email = ""; // Will fetch from user database below
  $occasion = $_POST['occasion'] ?? '';
  $date = $_POST['date'] ?? '';
  $delivery_time = $_POST['delivery_time'] ?? '';
  $delivery_address = $_POST['delivery_address'] ?? '';
  $message = $_POST['message'] ?? '';

    // Fetch email from user database
  $userDb = new mysqli($host, $user, $pass, "craftyHive");
  if ($userDb->connect_error) {
    $error = "User database connection failed: " . $userDb->connect_error;
  } else {
      $stmtEmail = $userDb->prepare("SELECT email FROM users WHERE full_name = ?");
      $stmtEmail->bind_param("s", $name);
      $stmtEmail->execute();
      $resultEmail = $stmtEmail->get_result();
      if ($resultEmail->num_rows > 0) {
          $row = $resultEmail->fetch_assoc();
          $email = $row['email'];
      } else {
          $error = "User email not found.";
      }
        $stmtEmail->close();
        $userDb->close();
  }

  $occasion = $_POST['occasion'] ?? '';
  $other_occasion = $_POST['other_occasion'] ?? '';
  $final_occasion = ($occasion === 'other' && !empty($other_occasion)) ? $other_occasion : $occasion;

  $bouquets = $_POST['bouquets'] ?? [];
  $quantities = $_POST['quantities'] ?? [];

  // Validate required fields
  if (!empty($name) && !empty($email) && !empty($date) && !empty($delivery_time) && !empty($delivery_address)) {
        
    // Insert into booking table
    $sql = "INSERT INTO `booking` (`user_id`, `occasion`, `date`, `delivery_time`, `delivery_address`, `message`) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
  // Fetch user id
  $userId = null;
  $userIdDb = new mysqli($host, $user, $pass, "craftyHive");
  if (!$userIdDb->connect_error) {
    $stmtUserId = $userIdDb->prepare("SELECT id FROM users WHERE full_name = ?");
    $stmtUserId->bind_param("s", $name);
    $stmtUserId->execute();
    $resultUserId = $stmtUserId->get_result();
    if ($resultUserId->num_rows > 0) {
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['id'];
    }
      $stmtUserId->close();
      $userIdDb->close();
  }


  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $final_message = $message; 
    $stmt->bind_param("isssss", $userId, $final_occasion, $date, $delivery_time, $delivery_address, $final_message);

    if ($stmt->execute()) {
      $bookingId = $stmt->insert_id; // ID of the newly inserted booking
      // Insert bouquets into booking_items table
      $stmtBouquet = $conn->prepare("INSERT INTO `booking_items` (`booking_id`, `bouquet_name`, `quantity`) VALUES (?, ?, ?)");

    foreach ($bouquets as $bouquet) {
      if (isset($quantities[$bouquet]) && $quantities[$bouquet] > 0) {
          $quantity = $quantities[$bouquet];
          $stmtBouquet->bind_param("isi", $bookingId, $bouquet, $quantity);
          $stmtBouquet->execute();
      }
    }

    $success = "Thank you, your bouquet has been booked!";
      header("refresh:3;url=index.php");
    } else {
        $error = "Database error: " . $stmt->error;
      }
        $stmt->close();
    } else {
        $error = "Failed to prepare booking query: " . $conn->error;
    }
  } else {
      if (empty($error)) {
        $error = "Please fill in all required fields.";
      }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Your Bouquet</title>

  <style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #fef9f4;
    padding: 2rem;
    margin: 0;
  }

  .booking {
    background: #c89666;
    max-width: 700px;
    margin: auto;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    color: #12343b;
  }

  .booking .heading {
    text-align: center;
    font-size: 2.2rem;
    font-weight: bold;
    margin-bottom: 2rem;
  }

  .booking form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
  }

  .booking form input,
  .booking form select,
  .booking form textarea {
    padding: 0.8rem 1rem;
    border: 1px solid #e0d2c1;
    border-radius: 12px;
    width: 100%;
    font-size: 1rem;
    margin-bottom: 1.2rem;
    box-sizing: border-box;
    background-color: #fffdfb;
  }

  .booking form textarea {
    resize: vertical;
    min-height: 100px;
  }

  .booking form button {
    width: 100%;
    background: #1e2e8a;
    color: white;
    border: none;
    padding: 0.9rem 1.5rem;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .booking form button:hover {
    background: #10152d;
  }

  .bouquet-selector {
    background-color: #fff9f5;
    padding: 1.5rem;
    border-radius: 16px;
    margin-top: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }

  .bouquet-selector p {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
  }

  .bouquet-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    padding: 10px 14px;
    border: 1px solid #ecd7cb;
    border-radius: 10px;
    margin-bottom: 10px;
    transition: background-color 0.3s ease;
  }

  .bouquet-item:hover {
    background-color: #fef0e9;
  }

  .bouquet-item label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    color: #333;
    flex: 1;
  }

  .bouquet-item input[type="number"] {
    width: 70px;
    padding: 5px 8px;
    font-size: 0.95rem;
    border-radius: 8px;
    border: 1px solid #d4bfa7;
    background-color: #fffefc;
  }

  .success, .error {
    padding: 1rem;
    text-align: center;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-weight: bold;
  }

  .success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  /* Toggle button */
  .toggle-btn {
    background: #244855;
    color: white;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 0.8rem;
    transition: background 0.3s;
  }

  .toggle-btn:hover {
    background: #19323c;
  }

  @media (max-width: 600px) {
    .bouquet-item {
      flex-direction: column;
      align-items: flex-start;
      gap: 8px;
    }

    .bouquet-item input[type="number"] {
      width: 100%;
    }

    .booking {
      padding: 1.5rem 1rem;
    }
}
</style>
</head>
<body>

<section class="booking" id="booking">
  <h2 class="heading"><span>Book</span> Your Bouquet Arrangement</h2>

  <?php if ($success): ?>
    <div class="success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

<form action="booking.php" method="POST">
<!-- Bouquet Selection Section -->
<div class="bouquet-selector" id="bouquetSelector">
  <p><strong>Choose Bouquets & Quantities:</strong></p>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Pink Ombre Bouquet"> Pink Ombre Bouquet -  ₱2000.00</label>
    <input type="number" name="quantities[Pink Ombre Bouquet]" min="1" placeholder="Qty">
  </div>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Sun-Drenched Delight Bouquet"> Sun-Drenched Delight Bouquet -  ₱1000.00</label>
    <input type="number" name="quantities[Sun-Drenched Delight Bouquet]" min="1" placeholder="Qty">
  </div>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Azure Dreams Bouquet"> Azure Dreams Bouquet - ₱2000.00</label>
    <input type="number" name="quantities[Azure Dreams Bouquet]" min="1" placeholder="Qty">
  </div>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Gentle Grace Bouquet"> Gentle Grace Bouquet - ₱1500.00</label>
    <input type="number" name="quantities[Gentle Grace Bouquet]" min="1" placeholder="Qty">
  </div>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Classic Beauty Bouquet"> Classic Beauty Bouquet - ₱1500.00</label>
    <input type="number" name="quantities[Classic Beauty Bouquet]" min="1" placeholder="Qty">
  </div>

  <div class="bouquet-item">
    <label><input type="checkbox" name="bouquets[]" value="Tulip Delight Bouquet"> Tulip Delight Bouquet - ₱1000.00</label>
    <input type="number" name="quantities[Tulip Delight Bouquet]" min="1" placeholder="Qty">
  </div>
</div>

    <label for="occasion">Occasion:</label>
    <select id="occasion" name="occasion" onchange="toggleOtherOccasion(this.value)">
      <option value="birthday">Birthday</option>
      <option value="wedding">Wedding</option>
      <option value="anniversary">Anniversary</option>
      <option value="other">Other</option>
    </select>

    <div id="other-occasion-wrapper" style="display: none;">
    <label for="other_occasion">Please specify:</label>
    <input type="text" id="other_occasion" name="other_occasion">
    </div>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required>

    <label for="delivery_time">Delivery Time:</label>
    <input type="datetime-local" id="delivery_time" name="delivery_time" required>

    <label for="delivery_address">Delivery Address:</label>
    <input type="text" id="delivery_address" name="delivery_address" required>

    <label for="message">Special Requests:</label>
    <textarea id="message" name="message" rows="5"></textarea> 

    <button type="submit">Book Now</button>
  </form>
</section>

<script>

function toggleOtherOccasion(value) {
  const wrapper = document.getElementById('other-occasion-wrapper');
  if (value === 'other') {
    wrapper.style.display = 'block';
  } else {
    wrapper.style.display = 'none';
  }
}

</script>

</body>
</html>

