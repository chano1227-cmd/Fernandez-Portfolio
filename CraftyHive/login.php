<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "craftyHive";


//establishing connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check the connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

//handle login when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //to see if the email exists in the database
$sql = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    //Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //Verify the password using md5() (for comparison)
if (md5($password) === $user['password_hash']) {
    $_SESSION['u_fullname'] = $user['full_name'];
            header("Location: index.php");  //redirect to homepage after successful login
            exit();
        } else {
            $error = "Oh no! Invalid password. Please try again!"; 
        }
    } else {
        $error = "Account not found. PLEASE REGISTER FIRST!";  
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            margin-top: 10px;
            color: #666;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #0000FF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #ffffff;
            color: #0000FF;
            border: 2px solid #0000FF;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>  <!-- error message -->
        <p>Don't have an account? <a href="registration.php">REGISTER here</a></p> <!-- link to register -->
    </div>
</body>
</html>

