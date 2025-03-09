<?php
$servername = "localhost"; 
$username = "root"; // Default XAMPP MySQL user
$password = ""; // Default is empty in XAMPP
$database = "quote_requests"; // Ensure this database exists

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hours = $_POST['hours'];
$passengers = $_POST['passengers'];
$pickup = $_POST['pickup'];
$destination = $_POST['destination'];
$pickupDate = $_POST['pickupDate'];
$captcha = $_POST['captcha'];

// Validate that all fields are filled
if (empty($name) || empty($email) || empty($phone) || empty($hours) || empty($passengers) || empty($pickup) || empty($destination) || empty($pickupDate) || empty($captcha)) {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
    exit;
}

// Use prepared statements for security
$stmt = $conn->prepare("INSERT INTO requests (name, email, phone, hours, passengers, pickup_location, destination, pickup_date, captcha_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiissi", $name, $email, $phone, $hours, $passengers, $pickup, $destination, $pickupDate, $captcha);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Quote request submitted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
