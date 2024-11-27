<?php
session_start();

// Ensure the session user_id exists and the user is a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    echo "<script>
            alert('Invalid patient ID. Please contact support.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

// Fetch the patient ID from the session
$patient_id = $_SESSION['user_id'];

// Database connection
include '../config/db.php';

// Check if the patient exists in the users table
$query = "SELECT id FROM users WHERE id = ? AND role = 'patient'";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // If no patient found, show an error
    echo "<script>
            alert('Invalid patient ID. Please contact support.');
            window.location.href = 'login.php';
          </script>";
    exit();
} else {
    // Proceed with appointment booking if patient exists
    // Fetch doctors for the dropdown
    $query = "SELECT id, CONCAT(first_name, ' ', last_name) AS name, specialty FROM doctors";
    $result = $conn->query($query);

    // Handle appointment booking form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $doctor_id = $_POST['doctor_id'];
        $appointment_date = $_POST['appointment_date'];
        $notes = $_POST['notes'];
        $status = 'Pending'; // Default status

        $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, status, notes) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisss', $patient_id, $doctor_id, $appointment_date, $status, $notes);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Appointment booked successfully!');
                    window.location.href = 'patient_dashboard.php';
                  </script>";
            exit();
        } else {
            $error_message = "Error booking appointment. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Om Chikitsalay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand img {
            width: 50px;
            height: 50px;
        }
        .card-header {
            background-color: #0056b3;
            color: white;
        }
        footer {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="patient_dashboard.php">
                <img src="../includes/img2.jpg" alt="Om Chikitsalay Logo"> Om Chikitsalay
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Booking Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Book an Appointment</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php elseif (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="doctor_id">Select Doctor</label>
                                <select class="form-control" id="doctor_id" name="doctor_id" required>
                                    <option value="">-- Choose a Doctor --</option>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo htmlspecialchars($row['name'] . ' (' . $row['specialty'] . ')'); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="appointment_date">Date</label>
                                <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                            </div>
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" placeholder="Add any additional information here..." rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Book Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Om Chikitsalay. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
