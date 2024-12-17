<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "test_sewingBook"; // The database name you created

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from service_booking table
$sql = "SELECT name, contact_numb, address, select_service, choose_date, choose_time 
        FROM service_booking";

$result = $conn->query($sql);

// Check if there are results
$bookingData = [];
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $bookingData[] = $row;
    }
} else {
    $bookingData = [];  // Empty array if no results are found
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking List</title>
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
  <main>
    <div class="booklist-container">
      <h1 class="booklist">Booking's List</h1>
      <div class="action-buttons">
        <button class="approve-btn">Booking list</button>
        <button class="pending-btn">Time slot list</button>
      </div>
    </div>
    <div class="booking-table">
        <table>
          <thead>
            <tr>
              <th>Member's Name</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Services</th>
              <th>Date</th>
              <th>Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($bookingData)) { ?>
                <tr>
                    <td colspan="7" class="no-data">No bookings found.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($bookingData as $booking) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking["name"]); ?></td>
                        <td><?php echo htmlspecialchars($booking["contact_numb"]); ?></td>
                        <td><?php echo htmlspecialchars($booking["address"]); ?></td>
                        <td><?php echo htmlspecialchars($booking["select_service"]); ?></td>
                        <td><?php echo htmlspecialchars($booking["choose_date"]); ?></td>
                        <td><?php echo htmlspecialchars($booking["choose_time"]); ?></td>
                        <td>
                            <button class="delete-btn" onclick="deleteBooking('<?php echo htmlspecialchars($booking['name']); ?>')">🗑️</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
          </tbody>
        </table>
    </div>
  </main>
  <!-- Lower Footer -->
  <div class="lower-footer">
    <p>&copy; 2024 Admin Panel. All Rights Reserved.</p>
  </div>
  <script>
    function deleteBooking(name) {
        if (confirm("Are you sure you want to delete the booking for " + name + "?")) {
            // Replace with actual implementation to delete the booking
            alert("Booking for " + name + " deleted (placeholder action).");
        }
    }
  </script>
</body>
</html>
