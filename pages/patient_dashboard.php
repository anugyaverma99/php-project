
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Location: login.php');
    exit();
}

// Database connection
include '../config/db.php';

// Fetch user details from users table
$user_id = $_SESSION['user_id']; // Get the logged-in user's ID
$query = "SELECT name, email FROM users WHERE id = ?"; // Query the users table for the ID
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle case when no user is found
if (!$user) {
    die("Error: No user found for the given session ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Om Chikitsalay</title>
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
            <h2>Welcome to your dashboard,  <?php echo htmlspecialchars($user['name']);?>!</h2>
    </div>

    <!-- Dashboard Content -->
    <div class="container mt-4">
        <div class="row">
           <!-- Appointments Section -->
            <!-- Appointments Section -->
<div class="container mt-4">
    <h3 class="text-center mb-4 text-primary">Your Appointments</h3>
    <div class="row justify-content-center">
        <!-- Appointment History Card -->
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center">
                    <div class="icon-container mb-3">
                        <img src="../includes/img3.jpg" alt="History Icon" style="width: 100px height: 50px">
                    </div>
                    <h4 class="card-title text-primary">Appointment History</h4>
                    <p class="card-text">
                        View all your past appointments and their details at a glance.
                    </p>
                    <a href="view_appointments.php" class="btn btn-primary btn-block">
                        <i class="fas fa-history"></i> View History
                    </a>
                </div>
            </div>
        </div>

        <!-- Book New Appointment Card -->
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center">
                    <div class="icon-container mb-3">
                        <img src="../includes/img5.jpg" alt="Appointment Icon" style="width: 80px height :100px">
                    </div>
                    <h4 class="card-title text-primary">Book a New Appointment</h4>
                    <p class="card-text">
                        Schedule your next visit with our expert medical team.
                    </p>
                    <a href="book_appointment.php" class="btn btn-secondary btn-block">
                        <i class="fas fa-calendar-plus"></i> Book Now
                    </a>
                </div>
            </div>
        </div>
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
