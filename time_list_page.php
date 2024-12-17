<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "test_sewingBook"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve time slot data
$sql = "SELECT id, date, time FROM add_time";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time List</title>
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>
  <!-- Upper Footer (Header) -->
  <div class="upper-footer">
    <div class="logo">
      <img src="your-logo-url.png" alt="Logo">
    </div>
    <div class="nav-buttons">
      <button onclick="location.href='adminDashboard.php'">Admin Dashboard</button>
      <button>Transaction Report</button>
      <button>Member’s Request</button>
      <button>Logout</button>
    </div>
  </div>

  <main>
    <div class="booklist-container">
      <h1 class="booklist">Time Slot List</h1>

      <div class="action-buttons">
        <button class="approve-btn">Booking list</button>
        <button class="pending-btn">Time slot list</button>
      </div>
    </div>
    <div class="booking-table">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                          <td>" . htmlspecialchars($row['date']) . "</td>
                          <td>" . htmlspecialchars($row['time']) . "</td>
                          <td>
                            <form method='POST' action='delete_time.php' style='display:inline;'>
                              <input type='hidden' name='id' value='" . $row['id'] . "'>
                              <button type='submit' class='delete-btn'>🗑️ Delete</button>
                            </form>
                          </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No time slots found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="button-container">
        <button type="button" class="submit-btn" style="background-color: #D9D9D9; color: #000000;" onclick="location.href='add_time.php'">Add New Time Slot</button>
      </div>
  </main>
  <!-- Lower Footer -->
  <div class="lower-footer">
    <p>&copy; 2024 Admin Panel. All Rights Reserved.</p>
  </div>
</body>
</html>
<?php
$conn->close();
?>
