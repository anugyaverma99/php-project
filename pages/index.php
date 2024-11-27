<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Chikitsalay - Hospital Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar {
            background-color: #0056b3; /* Darker Blue theme */
        }
        .navbar-brand img {
            width: 50px;
            height: 50px;
        }
        .jumbotron {
            background: #0a4275 url('hospital-banner.jpg') no-repeat center center/cover;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }
        .jumbotron h1 {
            font-size: 3rem;
        }
        footer {
            background-color: #003366;
            color: white;
        }
        .features {
            background: #f0f0f0; /* Slight gray for contrast */
            padding: 50px 0;
        }
        .feature-icon {
            font-size: 3rem;
            color: #0056b3;
        }
        .about-section {
            background: #e9ecef; /* Light gray */
            padding: 50px 0;
        }
        .stats-section {
            background: #004080; /* Darker blue for stats */
            color: white;
            padding: 50px 0;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
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
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Jumbotron -->
    <div class="jumbotron text-center d-flex align-items-center justify-content-center" style="height: 300px;">
        <div>
            <h1 class="display-4">Welcome to Om Chikitsalay</h1>
            <p class="lead">Your trusted healthcare partner for managing hospital operations efficiently.</p>
            <a href="register.php" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-user-injured feature-icon"></i>
                    <h3 class="mt-3">Patient Care</h3>
                    <p>Manage patient records, appointments, and medical history seamlessly.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-user-md feature-icon"></i>
                    <h3 class="mt-3">Doctor Management</h3>
                    <p>Effortlessly manage doctor schedules, availability, and profiles.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-users-cog feature-icon"></i>
                    <h3 class="mt-3">Admin Dashboard</h3>
                    <p>Comprehensive tools for hospital administrators to oversee operations.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <div class="container text-center">
            <h2 class="text-primary">About Us</h2>
            <p class="mt-3">Om Chikitsalay is committed to providing quality healthcare services with state-of-the-art facilities. We strive to streamline hospital management through innovative digital solutions.</p>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-section">
        <div class="container text-center">
            <h2>Our Impact</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <p class="stat-number">10,000+</p>
                    <p>Patients Treated</p>
                </div>
                <div class="col-md-4">
                    <p class="stat-number">500+</p>
                    <p>Doctors Onboard</p>
                </div>
                <div class="col-md-4">
                    <p class="stat-number">20+</p>
                    <p>Years of Service</p>
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
