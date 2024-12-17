<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_sewingBook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];

    $sql = "INSERT INTO signup (username, email, phone_number, password, user_type) 
            VALUES ('$username', '$email', '$phone_number', '$password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Signup successful!');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="mystyle.css">
  <script src="javascript.js" defer></script>
</head>
<body>
    <style>
        
  /* General Styles */
  body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #333;
      color: #333;
  }

  .container {
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
    background-image: url('images/background.jpg'); /* Replace with your image path */
    background-size: cover; /* Ensures the image covers the entire background */
    background-position: center; /* Centers the background image */
    background-repeat: no-repeat;
  }
  
  /* Left Image Section */
  .side-image {
    width: 40%; /* Takes up 40% of the width */
    height: 100%; /* Full height of the viewport */
    background-image: url('images/LeftImage.jpg'); /* Replace with your left-side image */
    background-position: center;
    background-size: cover; /* Ensures the image fits the container */
    background-repeat: no-repeat;
  }
  
  .form-container {
    flex: 1;
    max-width: 400px;
    background-color: #FDF1E4;
    padding: 20px;
    margin: 0;
    border-radius: 8px;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label {
    font-size: 14px;
    margin-bottom: 5px;
  }
  
  input, select, button {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  input:focus, select:focus {
    outline: none;
    border-color: #888;
  }
  
  button {
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #555;
  }
  
  a {
    color: #333;
    font-size: 12px;
    text-decoration: none;
  }
  
  a:hover {
    text-decoration: underline;
  }
  
  .forgot-password {
    margin-bottom: 20px;
    font-size: 12px;
    text-align: right;
  }
    </style>
  <div class="container">
    <div class="side-image"></div>
    <div class="form-container">
      <h1>SIGNUP</h1>
      <!-- Corrected form field names -->
      <form id="signupForm" method="POST" action="">
        <label for="username">Full Name<span>*</span></label>
        <input type="text" id="username" name="username" placeholder="Enter your name" required>
        
        <label for="signupEmail">Email<span>*</span></label>
        <input type="email" id="signupEmail" name="email" placeholder="Enter your email" required>
        
        <label for="phone_number">Contact No.<span>*</span></label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your number" required>
        
        <label for="signupPassword">Password<span>*</span></label>
        <input type="password" id="signupPassword" name="password" placeholder="Enter your password (6-8 digits)" required>
        
        <label for="signupAs">Signup As<span>*</span></label>
        <select id="signupAs" name="user_type" required>
          <option value="" disabled selected>Signup as</option>
          <option value="admin">Admin</option>
          <option value="user">Customer</option>
        </select>
        
        <button type="submit">Signup</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
      </form>
    </div>
  </div>
</body>
</html>
