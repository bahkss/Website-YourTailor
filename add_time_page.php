<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "test_sewingBook"; // The database name you created

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $add_date = $_POST['date'];
    $add_time = $_POST['time'];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO add_time (date, time) VALUES (?, ?)");
    $stmt->bind_param("ss", $add_date, $add_time); // "ss" means both parameters are strings

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>New time slot added successfully</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Time</title>
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>
  <!-- Upper Footer (Header) -->
  <div class="upper-footer">
    <div class="logo">
      <img src="https://s3-alpha-sig.figma.com/img/738e/3bca/6d35f3a0b1e6c5eae013f65c679be3ea?Expires=1733702400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=Vx3JegljYGP2WHdfp-ruwyb06HktJ~KHVehxpfp8LWi-MV2OfxhTkzI6iezUCOLT8kh0gufmN8MXSSaK0Bj6qtz9fDlaDaZWC4OZIAIcKNysIR1tAqXrjCEPxE2fE6HFziN36HoCLFbM3L8PhgNsLoy~JzEB8FJvs6q7bMyo5c3ngv6slxwzJGYTxEJPwb9PwsVYpXf2jTssD8iY7j13k10IU6XT92KnJEi7rcr8ZcmWv8q8v0s1e9gybuKrEgRPxisr0YjTdFBi-c~UQ6NnlOi-S96il4tZ~S~k-pO5ELF6CVEzapGMUuWwwmXID4r9P5tIMVZcG2VBR5X0pY4L7A__" alt="Logo">
    </div>
    <div class="nav-buttons">
      <button onclick="location.href='adminDashboard.php'">Admin Dashboard</button>
      <button>Transaction Report</button>
      <button>Member’s Request</button>
      <button>Logout</button>
    </div>
  </div>

  <!-- Main Section -->
  <main>
    <div class="timeslot">
      <h1 class="h1_timeslot">Time Slot’s List</h1>
    </div>
    <div>
        <h3 class="add_time">Add New Time</h3>
    </div>
    
    <!-- Form to Add Time Slot -->
    <form action="" method="POST">
      <div class="add-time-container">
        <div class="form-group">
          <label for="date">Add Date</label>
          <input type="date" id="date" name="date" class="input-date" required>
        </div>
        <div class="form-group">
          <label for="time">Add Time</label>
          <input type="time" id="time" name="time" class="input-time" required>
        </div>
      </div>
      <div>
        <button type="submit" class="submit-btn">Add Time Slot</button>
      </div>
    </form>
  </main>

  <!-- Lower Footer -->
  <div class="lower-footer">
    <p>&copy; 2024 Admin Panel. All Rights Reserved.</p>
  </div>
</body>
</html>
