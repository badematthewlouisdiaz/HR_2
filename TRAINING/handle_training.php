<?php
header('Content-Type: application/json');
ini_set('display_errors', 1); // For debugging, remove on production
error_reporting(E_ALL);

// Connect to DB
include("../db.php"); // This should set $connections
$db_name = "hr2_training";
$conn = $connections[$db_name] ?? die(json_encode(["status" => "error", "message" => "DB connection not found"]));

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

$errors = [];

// Validate fields
if (!isset($input['name']) || trim($input['name']) === '') $errors[] = "Name is required.";
if (!isset($input['type']) || trim($input['type']) === '') $errors[] = "Type is required.";
if (!isset($input['description']) || trim($input['description']) === '') $errors[] = "Description is required.";
if (!isset($input['start_date']) || trim($input['start_date']) === '') $errors[] = "Start date is required.";
if (!isset($input['end_date']) || trim($input['end_date']) === '') $errors[] = "End date is required.";
if (!isset($input['location']) || trim($input['location']) === '') $errors[] = "Location is required.";
if (!isset($input['max_participants']) || !is_numeric($input['max_participants'])) $errors[] = "Max participants must be a number.";

if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Validation failed.",
        "errors" => $errors
    ]);
    exit;
}

// Prepare and execute insert
$stmt = $conn->prepare("INSERT INTO trainings (name, type, description, start_date, end_date, location, max_participants) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssssi",
    $input['name'],
    $input['type'],
    $input['description'],
    $input['start_date'],
    $input['end_date'],
    $input['location'],
    $input['max_participants']
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "training_id" => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "DB insert failed: " . $conn->error,
        "errors" => []
    ]);
}

$stmt->close();
$conn->close();
?>