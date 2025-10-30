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
    $survey_name = $_POST['survey_name'] ?? '';
    $survey_type = $_POST['survey_type'] ?? '';
    $competencies = isset($_POST['competencies']) ? implode(",", $_POST['competencies']) : '';
    $participants = isset($_POST['participants']) ? implode(",", $_POST['participants']) : '';
    $due_date = $_POST['due_date'] ?? '';
    
    // Validate required fields
    if (empty($survey_name) || empty($survey_type) || empty($due_date)) {
        $_SESSION['error'] = "Please fill in all required fields";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO sucession (data_type, name, survey_type, competencies, participants, due_date, status) VALUES (?, ?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("ssssss", $data_type, $survey_name, $survey_type, $competencies, $participants, $due_date);
    
    $data_type = "survey";
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Survey '$survey_name' created successfully!";
    } else {
        $_SESSION['error'] = "Error creating survey: " . $conn->error;
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