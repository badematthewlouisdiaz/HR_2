<?php
// Delete training entry: POST JSON with training_id

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

$id = isset($data['training_id']) ? intval($data['training_id']) : 0;

if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing training_id']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM trainings WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Training deleted', 'training_id' => $id]);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();