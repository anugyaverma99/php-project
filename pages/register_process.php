<?php
// Include database connection
include '../config/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check for missing fields
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die('All fields are required!');
    }

    // Insert into the appropriate table based on the role
    if ($role === 'patient') {
        $table = 'patients';
    } elseif ($role === 'doctor') {
        $table = 'doctors';
    } elseif ($role === 'admin') {
        $table = 'admins';
    } else {
        die('Invalid role selected!');
    }

    $query = "INSERT INTO users (name, email, password,role) VALUES ('$name', '$email', '$password','$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
