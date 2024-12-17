<?php
// Start the session to store login information
session_start();

// Database connection
$databaseHost = 'localhost';
$databaseName = 'test_sewingBook';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $loginAs = $mysqli->real_escape_string($_POST['loginAs']);

    // Query to check if the user exists
    $query = "SELECT * FROM signup WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Check the user role
            if ($loginAs === "admin" && $user['username'] === "admin") {
                $_SESSION['user'] = $user;
                header("Location: adminDashboard.php");
                exit();
            } elseif ($loginAs === "user") {
                $_SESSION['user'] = $user;
                header("Location: userHomepage.html");
                exit();
            } else {
                echo "Invalid login type for the provided credentials.";
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="mystyle.css"> <!-- Include your CSS here -->
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
            background-image: url('images/background.jpg');
            background-size: cover; /* Ensures the image covers the entire background */
            background-position: center; /* Centers the background image */
            background-repeat: no-repeat;
          }
          
          /* Left Image Section */
          .side-image {
            width: 40%; /* Takes up 40% of the width */
            height: 82%;
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
            <h1>LOGIN</h1>
            <form method="POST" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                
                <label for="loginAs">Login As</label>
                <select id="loginAs" name="loginAs" required>
                    <option value="" disabled selected>Login as</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                
                <a href="#" class="forgot-password">Forgot password?</a>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Signup</a></p>
            </form>
        </div>
    </div>
</body>
</html>
