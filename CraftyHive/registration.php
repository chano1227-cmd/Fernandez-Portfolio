<?php

$servername= "localhost";
$username = "root"; 
$password = "";   
$dbname = "craftyHive";

//establish connection
$conn = new mysqli($servername,$username,$password,$dbname);

if( $conn -> connect_error){
    die("connection_failed:". $conn -> connect_error);
}

if(isset($_POST['submit'])){

    $fullname = $_POST ['fullName'];
    $email = $_POST ['email'];
    $pass = md5($_POST['password']);
    $confirmpass = md5($_POST['confirmPassword']);

$sql = $conn -> prepare("INSERT INTO `users`( `username`, `password_hash`, `email`, `full_name`) 
    VALUES (?, ?, ?, ?)");

    $sql -> bind_param("ssss", $fullname, $pass, $email, $fullname);

    try {
        if ($sql -> execute()){
            echo "registration successful";
        } else {
            echo "Registration failed: " . $sql->error;
        }
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "Registration failed: Email address already registered.";
        } else {
            echo "Registration failed: " . $e->getMessage();
        }
    }

    $sql -> close();
}
    $conn -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

   
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
        .registration-container {
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
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
    <div class="registration-container">
        <h2>Create an Account</h2>
        <form id="registrationForm" method="POST">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" name="submit" class="submit-btn">Register</button>
        </form>
        <div class="login-link">
        <p>Already have an account? <a href="login.php">LOG IN here! </a></p>
        </div>
    </div>


</body>
</html>
