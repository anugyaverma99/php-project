<?php
session_start();

// Check if the user is logged in and has a doctor role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}

// Database connection
include '../config/db.php';

// Fetch user details (doctor) from the users table based on user_id
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If no record is found, handle the error (optional)
if (!$user) {
    die("User details not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Om Chikitsalay</title>
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
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
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
            <h2>Welcome, Dr. <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
        </div>
    </div>

    <!-- Doctor Dashboard Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- View Appointments -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../includes/img7.jpg" class="card-img-top" alt="View Appointments">
                    <div class="card-body text-center">
                        <h5 class="card-title">View Appointments</h5>
                        <p class="card-text">Check and manage your appointments.</p>
                        <a href="viewdoctor_appointments.php" class="btn btn-primary">View Appointments</a>
                    </div>
                </div>
            </div>

            <!-- Manage Patient Reports -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../includes/img8.jpg" class="card-img-top" alt="Manage Reports">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manage Patient Reports</h5>
                        <p class="card-text">Access and update patient reports.</p>
                        <a href="manage_reports.php" class="btn btn-primary">Manage Reports</a>
                    </div>
                </div>
            </div>

            <!-- Update Profile -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="../includes/img9.jpg" class="card-img-top" alt="Update Profile">
                    <div class="card-body text-center">
                        <h5 class="card-title">Update Profile</h5>
                        <p class="card-text">Edit your personal details and contact information.</p>
                        <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
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
