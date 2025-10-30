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
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $current_position = $_POST['current_position'] ?? '';
    $department = $_POST['department'] ?? '';
    $potential_role = $_POST['potential_role'] ?? '';
    $readiness_timeline = $_POST['readiness_timeline'] ?? '';
    $strengths = $_POST['strengths'] ?? '';
    $development_areas = $_POST['development_areas'] ?? '';
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($current_position) || 
        empty($department) || empty($potential_role) || empty($readiness_timeline)) {
        $_SESSION['error'] = "Please fill in all required fields";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    // Calculate a random competency score for demo purposes
    $competency_score = rand(70, 95);
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO sucession (data_type, first_name, last_name, department, current_position, potential_role, readiness_timeline, strengths, development_areas, competency_score, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("sssssssssi", $data_type, $first_name, $last_name, $department, $current_position, $potential_role, $readiness_timeline, $strengths, $development_areas, $competency_score);
    
    $data_type = "candidate";
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Candidate '$first_name $last_name' added successfully!";
    } else {
        $_SESSION['error'] = "Error adding candidate: " . $conn->error;
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