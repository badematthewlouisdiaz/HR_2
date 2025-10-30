<?php
// Get training(s): GET (all or by id via query param)

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

$id = isset($_GET['training_id']) ? intval($_GET['training_id']) : 0;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM trainings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $training = $result->fetch_assoc();
    if ($training) {
        echo json_encode(['status' => 'success', 'training' => $training]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Training not found']);
    }
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM trainings ORDER BY start_date DESC");
    $trainings = [];
    while ($row = $result->fetch_assoc()) {
        $trainings[] = $row;
    }
    echo json_encode(['status' => 'success', 'trainings' => $trainings]);
}