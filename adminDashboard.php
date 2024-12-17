<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "test_sewingbook"; // The database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count total members from the signup table
$membersQuery = "SELECT COUNT(*) as total_members FROM signup";
$membersResult = $conn->query($membersQuery);
$totalMembers = $membersResult->fetch_assoc()['total_members'] ?? 0;

// Query to count total bookings from the service_booking table
$bookingsQuery = "SELECT COUNT(*) as total_bookings FROM service_booking";
$bookingsResult = $conn->query($bookingsQuery);
$totalBookings = $bookingsResult->fetch_assoc()['total_bookings'] ?? 0;

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>
  <!-- Upper Footer (Header) -->
  <div class="upper-footer">
    <div class="logo">
        <img src="https://s3-alpha-sig.figma.com/img/738e/3bca/6d35f3a0b1e6c5eae013f65c679be3ea?Expires=1733702400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=Vx3JegljYGP2WHdfp-ruwyb06HktJ~KHVehxpfp8LWi-MV2OfxhTkzI6iezUCOLT8kh0gufmN8MXSSaK0Bj6qtz9fDlaDaZWC4OZIAIcKNysIR1tAqXrjCEPxE2fE6HFziN36HoCLFbM3L8PhgNsLoy~JzEB8FJvs6q7bMyo5c3ngv6slxwzJGYTxEJPwb9PwsVYpXf2jTssD8iY7j13k10IU6XT92KnJEi7rcr8ZcmWv8q8v0s1e9gybuKrEgRPxisr0YjTdFBi-c~UQ6NnlOi-S96il4tZ~S~k-pO5ELF6CVEzapGMUuWwwmXID4r9P5tIMVZcG2VBR5X0pY4L7A__" alt="Logo">
    </div>
    <div class="nav-buttons">
      <button>Admin Dashboard</button>
      <button>Transaction Report</button>
      <button>Member’s Request</button>
      <button>Logout</button>
    </div>
  </div>

  <!-- Main Content -->
  <main>
    <!-- First Section: Statistic Overview -->
    <section class="statistics">
      <h2>Statistic Overview</h2>
      <div class="stats-container">
        <div class="stat-item">
          <h3>Total Members</h3>
          <p><?php echo $totalMembers; ?></p>
        </div>
        <div class="stat-item">
          <h3>Total Bookings</h3>
          <p><?php echo $totalBookings; ?></p>
        </div>
        <div class="stat-item">
          <h3>Pending Requests</h3>
          <p>--</p>
        </div>
      </div>
    </section>

    <!-- Other Sections -->
    <section class="member-request-section">
      <h2 class="section-title">Member's Request Overview</h2>
      <!-- Search Bar -->
      <div class="search-bar">
        <input type="text" placeholder="Search by Member's Name, Date, or Address">
      </div>
      <!-- Buttons -->
      <div class="action-buttons">
        <button class="approve-btn" onclick="location.href='book_lists.php'">Booking list </button>
        <button class="pending-btn" onclick="location.href='time_lists.php'">Time slot list </button>
      </div>
    </section>
  </main>

  <!-- Lower Footer -->
  <div class="lower-footer">
    <p>&copy; 2024 Admin Panel. All Rights Reserved.</p>
  </div>
</body>
</html>
