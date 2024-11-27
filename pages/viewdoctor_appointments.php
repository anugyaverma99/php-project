<?php
session_start();
include '../config/db.php';

// Debugging: Check session data
var_dump($_SESSION);

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit();
}

// Get the doctor's ID from the session
$doctor_id = $_SESSION['doctor_id']; // This is set after fetching it using user_id

// Get the doctor's name from the session
$doctor_name = $_SESSION['doctor_name'];

// Query to get appointments for the logged-in doctor using doctor_id from appointments table
$query = "
    SELECT a.id AS appointment_id, a.appointment_date, a.status, a.notes, 
           p.first_name AS patient_first_name, p.last_name AS patient_last_name, 
           p.email AS patient_email, p.contact_number AS patient_contact_number
    FROM appointments a
    JOIN patients p ON a.patient_id = p.id
    WHERE a.doctor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Appointments for Dr. $doctor_name</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Appointment ID</th><th>Date</th><th>Status</th><th>Patient Name</th><th>Patient Email</th><th>Contact Number</th><th>Notes</th></tr></thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['patient_first_name']) . " " . htmlspecialchars($row['patient_last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['patient_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['patient_contact_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['notes']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No appointments found for Dr. $doctor_name.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Appointment details table or message will be displayed here -->
    </div>
</body>
</html>
