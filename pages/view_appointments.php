<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Location: login.php');
    exit();
}

// Database connection
include '../config/db.php';

$patient_id = $_SESSION['user_id'];

// Fetch the patient's appointments
$query = "SELECT a.id, a.appointment_date, a.status, a.notes, d.first_name, d.last_name, d.specialty 
          FROM appointments a
          JOIN doctors d ON a.doctor_id = d.id
          WHERE a.patient_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the patient has any appointments
if ($result->num_rows === 0) {
    $no_appointments_message = "You have no upcoming appointments.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments - Om Chikitsalay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 1000px;
        }
        .table th, .table td {
            text-align: center;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0056b3;
            color: white;
        }
        footer {
            background-color: #0056b3;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #007bff;">
        <div class="container">
            <a class="navbar-brand" href="#">Om Chikitsalay</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h4>Your Appointments</h4>
            </div>
            <div class="card-body">
                <?php if (isset($no_appointments_message)): ?>
                    <div class="alert alert-info text-center"><?php echo $no_appointments_message; ?></div>
                <?php else: ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Specialization</th>
                                <th>Appointment Date</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                    <td><?php echo $row['specialty']; ?></td>
                                    <td><?php echo date('F j, Y', strtotime($row['appointment_date'])); ?></td>
                                    <td>
                                        <?php 
                                            if ($row['status'] == 'Confirmed') {
                                                echo '<span class="badge badge-success">Confirmed</span>';
                                            } elseif ($row['status'] == 'Pending') {
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Canceled</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row['notes'] ? $row['notes'] : 'No notes provided'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Om Chikitsalay. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
