<?php
session_start();

// Check if the user is logged in and has an admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Database connection
include '../config/db.php';

// Fetch total doctors
$query_total_doctors = "SELECT COUNT(*) AS total FROM doctors";
$result_total_doctors = $conn->query($query_total_doctors);
$total_doctors = $result_total_doctors->fetch_assoc()['total'];

// Fetch specialties count
$query_specialties = "SELECT specialty, COUNT(*) AS count FROM doctors WHERE specialty IS NOT NULL GROUP BY specialty";
$result_specialties = $conn->query($query_specialties);

// Fetch most experienced doctor
$query_most_experienced = "SELECT CONCAT(first_name, ' ', last_name) AS name, specialty FROM doctors WHERE specialty IS NOT NULL ORDER BY id DESC LIMIT 1";
$result_most_experienced = $conn->query($query_most_experienced);
$most_experienced = $result_most_experienced->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Statistics - Om Chikitsalay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Om Chikitsalay</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
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

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="text-center">Doctor Statistics</h2>
        <div class="row mt-4">
            <!-- Total Doctors -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-header bg-primary text-white">
                        Total Doctors
                    </div>
                    <div class="card-body">
                        <h4><?php echo $total_doctors; ?></h4>
                        <p>Total number of doctors in the system.</p>
                    </div>
                </div>
            </div>
            <!-- Most Recent Doctor -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-header bg-success text-white">
                        Most Recently Added Doctor
                    </div>
                    <div class="card-body">
                        <h4><?php echo htmlspecialchars($most_experienced['name']); ?></h4>
                        <p>Specialty: <?php echo htmlspecialchars($most_experienced['specialty']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Specialties -->
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow">
                    <div class="card-header bg-warning text-white">
                        Specialties Count
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php while ($specialty = $result_specialties->fetch_assoc()): ?>
                                <li><?php echo htmlspecialchars($specialty['specialty']); ?>: <?php echo $specialty['count']; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 mt-5 bg-primary text-white">
        <p>&copy; 2024 Om Chikitsalay. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
