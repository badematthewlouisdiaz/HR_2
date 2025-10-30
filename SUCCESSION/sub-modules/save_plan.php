<?php
session_start();
include("../../db.php");

// Set character set to utf8
$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    function sanitize_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $employee_id = sanitize_input($_POST["employee_id"]);
    $employee_name = sanitize_input($_POST["employee_name"]);
    $position = sanitize_input($_POST["position"]);
    $potential_successor_id = sanitize_input($_POST["potential_successor_id"]);
    $potential_successor_name = sanitize_input($_POST["potential_successor_name"]);
    $readiness_level = sanitize_input($_POST["readiness_level"]);
    $development_plan = sanitize_input($_POST["development_plan"]);
    $assessment_date = sanitize_input($_POST["assessment_date"]);

    // Validate required fields
    if (empty($employee_id) || empty($employee_name) || empty($position) || 
        empty($potential_successor_id) || empty($potential_successor_name) || 
        empty($readiness_level) || empty($assessment_date)) {
        
        echo json_encode(["status" => "error", "message" => "All required fields must be filled out."]);
        exit;
    }

    // Check if record exists (based on employee_id)
    $check_sql = "SELECT succession_id FROM succession_planning WHERE employee_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $employee_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $sql = "UPDATE succession_planning SET 
                    employee_name = ?, 
                    position = ?, 
                    potential_successor_id = ?, 
                    potential_successor_name = ?, 
                    readiness_level = ?, 
                    development_plan = ?, 
                    assessment_date = ?, 
                    updated_at = NOW()
                WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $employee_name, 
            $position, 
            $potential_successor_id, 
            $potential_successor_name, 
            $readiness_level, 
            $development_plan, 
            $assessment_date, 
            $employee_id
        );
    } else {
        // Insert new record
        $sql = "INSERT INTO succession_planning 
                (employee_id, employee_name, position, potential_successor_id, 
                potential_successor_name, readiness_level, development_plan, assessment_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $employee_id, 
            $employee_name, 
            $position, 
            $potential_successor_id, 
            $potential_successor_name, 
            $readiness_level, 
            $development_plan, 
            $assessment_date
        );
    }

    // Execute query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Succession plan saved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }

    // Close
    $check_stmt->close();
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
