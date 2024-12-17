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

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = $_POST['name'];
    $contact_numb = $_POST['contact_numb'];
    $address = $_POST['address'];
    $select_service = $_POST['select_service'];
    $description = $_POST['description'];
    $choose_date = $_POST['choose_date'];
    $choose_time = $_POST['choose_time'];
    $payment = $_POST['payment'];

    // Debugging: Check if form data is being received
    error_log("Form Data: name=$name, contact_numb=$contact_numb, address=$address, select_service=$select_service, description=$description, choose_date=$choose_date, choose_time=$choose_time, payment=$payment");

    // Insert booking into the `service_booking` table
    $stmt = $conn->prepare("INSERT INTO service_booking (name, contact_numb, address, select_service, description, choose_date, choose_time, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('MySQL prepare statement failed: ' . $conn->error);
    }

    $stmt->bind_param("ssssssss", $name, $contact_numb, $address, $select_service, $description, $choose_date, $choose_time, $payment);

    // Execute the booking insertion
    if ($stmt->execute()) {
        // Delete the selected time slot from `add_time` table
        $deleteStmt = $conn->prepare("DELETE FROM add_time WHERE date = ? AND time = ?");
        if ($deleteStmt === false) {
            die('MySQL prepare statement failed: ' . $conn->error);
        }

        $deleteStmt->bind_param("ss", $choose_date, $choose_time);
        if ($deleteStmt->execute()) {
            $message = "Booking saved successfully, and the time slot has been removed!";
        } else {
            $message = "Booking saved successfully, but failed to delete the selected time slot.";
        }

        $deleteStmt->close();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch available slots for the form
$sql = "SELECT date, time FROM add_time ORDER BY date, time";
$result = $conn->query($sql);
$availableSlots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $availableSlots[] = $row; // Store date and time
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Booking</title>
  <link rel="stylesheet" href="mystyle.css">
  <style>
    body{
      background-image: url('images/BookingBackground.jpg');
    }
    
    .booking-container, .message-container {
      max-width: 600px;
      max-height: 100vh;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #514644;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .booking-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      max-height: 80vh;
      overflow-y: auto;
    }

    #description {
      height: 1000px;
      resize: none; /* Prevent resizing */
      padding: 10px;
      font-size: 14px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .time-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 0px;
      margin-top: 10px;
    }

    .time-button {
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .time-button:hover {
      background-color: #45a049;
    }

    .success {
      color: green;
      font-weight: bold;
    }

    .error {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php if (!empty($message)): ?>
    <div class="message-container">
      <p class="<?php echo $message === 'Booking saved successfully!' ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
      </p>
      <a href="booking_homepage.html">Back to Booking Page</a>
    </div>
  <?php else: ?>
    <div class="booking-container">
      <form class="booking-form" method="POST" action="">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>

        <label for="contact">Contact No</label>
        <input type="text" id="contact" name="contact_numb" placeholder="Enter your contact number" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Enter your full address" required>

        <label for="service">Select Service</label>
        <select id="service" name="select_service" required>
          <option value="Alterations">Alterations</option>
          <option value="Custom Tailoring">Custom Tailoring</option>
          <option value="Repairs">Repairs</option>
        </select>

        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Give a short description" required></textarea>

        <label for="date">Choose Date</label>
        <input type="date" id="date" name="choose_date" required>

        <label for="time">Choose Time</label>
        <input type="time" id="time" name="choose_time" required>

        <div class="time-buttons">
          <?php
          if (!empty($availableSlots)) {
            foreach ($availableSlots as $slot) {
              echo '<button type="button" class="time-button" data-date="' . $slot['date'] . '" data-time="' . $slot['time'] . '">' . $slot['date'] . ' ' . $slot['time'] . '</button>';
            }
          } else {
            echo '<p>No available slots at the moment.</p>';
          }
          ?>
        </div>

        <label for="payment">Select Payment</label>
        <select id="payment" name="payment" required>
          <option value="Cash">Cash</option>
          <option value="Online Payment">Online Payment</option>
          <option value="Credit Card">Credit Card</option>
        </select>

        <button type="submit" id="book-now">Book Now</button>
      </form>
    </div>
  <?php endif; ?>

  <script>
    document.querySelectorAll('.time-button').forEach(function(button) {
      button.addEventListener('click', function() {
        var selectedDate = this.getAttribute('data-date');
        var selectedTime = this.getAttribute('data-time');
        
        document.getElementById('date').value = selectedDate;
        document.getElementById('time').value = selectedTime;
      });
    });
  </script>
</body>
</html>
