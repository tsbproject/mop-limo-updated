<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Default in XAMPP
$password = ""; // Default is empty
$database = "quote_requests"; // Use your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get Form Data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hours = $_POST['hours'];
$passengers = $_POST['passengers'];
$pickup = $_POST['pickup'];
$destination = $_POST['destination'];
$pickupDate = $_POST['pickupDate'];

// Validate Input
if (empty($name) || empty($email) || empty($phone) || empty($hours) || empty($passengers) || empty($pickup) || empty($destination) || empty($pickupDate)) {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
    exit;
}

// Insert Data into Database (Using Prepared Statement)
$stmt = $conn->prepare("INSERT INTO request (name, email, phone, hours, passengers, pickup_location, destination, pickup_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiiss", $name, $email, $phone, $hours, $passengers, $pickup, $destination, $pickupDate);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Quote request submitted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
