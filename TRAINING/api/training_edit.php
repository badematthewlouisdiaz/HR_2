<?php
// Update training entry: POST JSON

header('Content-Type: application/json');
session_start();
include("../db.php");

$db_name = "hr2_training";
$conn = $connections[$db_name] ?? null;

if (!$conn) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => "❌ Connection not found for $db_name"]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    exit;
}

$errors = [];
$id = isset($data['training_id']) ? intval($data['training_id']) : 0;

if (!$id) $errors[] = 'Missing training_id';

$name = trim($data['name'] ?? '');
$type = trim($data['type'] ?? '');
$description = trim($data['description'] ?? '');
$start_date = trim($data['start_date'] ?? '');
$end_date = trim($data['end_date'] ?? '');
$location = trim($data['location'] ?? '');
$max_participants = intval($data['max_participants'] ?? 0);

if (!$name) $errors[] = 'Training name is required';
if (!$type) $errors[] = 'Type is required';
if (!$description) $errors[] = 'Description is required';
if (!$start_date) $errors[] = 'Start date is required';
if (!$end_date) $errors[] = 'End date is required';
if (!$location) $errors[] = 'Location is required';
if ($max_participants <= 0) $errors[] = 'Max participants must be greater than 0';

if ($errors) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Validation error', 'errors' => $errors]);
    exit;
}

$stmt = $conn->prepare(
    "UPDATE trainings SET 
        name = ?, 
        type = ?, 
        description = ?, 
        start_date = ?, 
        end_date = ?, 
        location = ?, 
        max_participants = ?
    WHERE id = ?"
);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

$stmt->bind_param(
    "ssssssii",
    $name,
    $type,
    $description,
    $start_date,
    $end_date,
    $location,
    $max_participants,
    $id
);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Training updated successfully',
        'training_id' => $id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $stmt->error
    ]);
}

$stmt->close();