<?php
session_start();
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hr2_soliera_usm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed']));
}

// Get the posted data
$input = json_decode(file_get_contents('php://input'), true);
$moduleId = $input['moduleId'] ?? null;
$status = $input['status'] ?? null;

if ($moduleId && $status) {
    // Update module status
    $stmt = $conn->prepare("UPDATE learning_modules SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $moduleId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Module status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating module status']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}

$conn->close();
?>