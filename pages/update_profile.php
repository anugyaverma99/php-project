<?php
session_start();
include '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch doctor ID from session (assuming session holds the doctor's ID)
$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor details from the 'doctors' table
$query = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

if (!$doctor) {
    echo "Doctor not found.";
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);
    $specialty = trim($_POST['specialty']);

    // Input validation
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $error = "First name, last name, and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Update doctor details in the database (only available fields in doctors table)
        $update_query = "
            UPDATE doctors 
            SET first_name = ?, last_name = ?, email = ?, 
                contact_number = ?, specialty = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param(
            "sssssi",
            $first_name,
            $last_name,
            $email,
            $contact_number,
            $specialty,
            $doctor_id
        );

        if ($stmt->execute()) {
            $success = "Profile updated successfully.";
            // Refresh doctor details
            header("Location: update_profile.php");
            exit();
        } else {
            $error = "Error updating profile: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Profile</h2>
        
        <!-- Display error message if any -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Display success message if any -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Profile update form -->
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" 
                       value="<?php echo htmlspecialchars($doctor['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" 
                       value="<?php echo htmlspecialchars($doctor['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" 
                       value="<?php echo htmlspecialchars($doctor['contact_number']); ?>">
            </div>
            <div class="form-group">
                <label for="specialty">Specialty</label>
                <input type="text" class="form-control" id="specialty" name="specialty" 
                       value="<?php echo htmlspecialchars($doctor['specialty']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>
