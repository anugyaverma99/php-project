<?php
session_start();

// Check if the user is logged in and has an admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Database connection
include '../config/db.php';

// Fetch admin details (optional, for personalization)
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$query_doctor_performance = "SELECT d.name AS doctor_name, 
                             COUNT(a.id) AS total_appointments, 
                             SUM(CASE WHEN a.status = 'completed' THEN 1 ELSE 0 END) AS completed_appointments, 
                             SUM(CASE WHEN a.status = 'pending' THEN 1 ELSE 0 END) AS pending_appointments
                             FROM appointments a
                             JOIN users d ON a.doctor_id = d.id AND d.role = 'doctor'
                             GROUP BY d.id
                             ORDER BY total_appointments DESC";

// Execute the query and check for errors
$result_doctor_performance = $conn->query($query_doctor_performance);

// Check for query execution errors
if (!$result_doctor_performance) {
    die("Error executing query: " . $conn->error);  // This will display the error if the query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Om Chikitsalay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand img {
            width: 50px;
            height: 50px;
        }
        footer {
            background-color: #0056b3;
            color: white;
        }
        .dashboard-header {
            background-color: #0056b3;
            color: white;
            padding: 20px;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-primary:hover {
            background-color: #003f7f;
            border-color: #003f7f;
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            text-align: center;
        }
        .card-body h4 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../includes/img2.jpg" alt="Om Chikitsalay Logo"> Om Chikitsalay
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="container mt-4">
        <div class="dashboard-header text-center">
            <h2>Welcome, <?php echo htmlspecialchars($admin['name']); ?>!</h2>
            <p>Your Role: Admin</p>
        </div>
    </div>

    <!-- Admin Dashboard Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Manage Users -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="../includes/img6.jpg" class="card-img-top" alt="Manage Users">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Manage Users</h4>
                    </div>
                    <div class="card-body">
                        <p>View, add, edit, or delete users.</p>
                        <a href="manage_users.php" class="btn btn-primary btn-block">Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- View Appointments -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <img src="../includes/img7.jpg" class="card-img-top" alt="View Appointments">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Appointments</h4>
                    </div>
                    <div class="card-body">
                        <p>View and manage all patient appointments.</p>
                        <a href="viewadmin_appointments.php" class="btn btn-primary btn-block">View Appointments</a>
                    </div>
                </div>
            </div>

                <!-- Manage Doctors -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <img src="../includes/img8.jpg" class="card-img-top" alt="Doctor Statistics">
            <div class="card-header text-center bg-primary text-white">
                <h4>Doctor Statistics</h4>
            </div>
            <div class="card-body">
                <p>View overall statistics about doctors' performance and availability.</p>
                <a href="doctor_statistics.php" class="btn btn-primary btn-block">View Statistics</a>
            </div>
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
