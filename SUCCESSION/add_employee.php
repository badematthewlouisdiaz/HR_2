<?php
session_start();

include("../db.php");
$db_name = "h2_succession";
$conn = $connections[$db_name] ?? die("❌ Connection not found for $db_name");



// Check connection
if ($conn->connect_error) {
    $_SESSION['error'] = "Database connection failed: " . $conn->connect_error;
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $employee_id = $_POST['employee_id'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $department = $_POST['department'] ?? '';
    $position = $_POST['position'] ?? '';
    $hire_date = $_POST['hire_date'] ?? '';
    
    // Validate required fields
    if (empty($employee_id) || empty($first_name) || empty($last_name) || 
        empty($email) || empty($department) || empty($position)) {
        $_SESSION['error'] = "Please fill in all required fields";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO sucession (data_type, employee_id, first_name, last_name, email, department, position, hire_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("ssssssss", $data_type, $employee_id, $first_name, $last_name, $email, $department, $position, $hire_date);
    
    $data_type = "employee";
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Employee '$first_name $last_name' added successfully!";
    } else {
        $_SESSION['error'] = "Error adding employee: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    $_SESSION['error'] = "Invalid request method";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>