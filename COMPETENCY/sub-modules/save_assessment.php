<?php
session_start();
include("../../db.php");

// Check if logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: ../../login.php?error=not_logged_in");
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../competency_form.php?error=invalid_method");
    exit;
}

// Get session details
$employee_id   = $_SESSION['employee_id'];
$employee_name = $_SESSION['employee_name'] ?? '';

// Get form inputs
$competency_name   = trim($_POST['competency_name'] ?? '');
$category          = trim($_POST['category'] ?? '');
$proficiency_level = $_POST['proficiency_level'] ?? '';
$required_level    = $_POST['required_level'] ?? '';
$required_value    = $_POST['required_value'] ?? '';
$assessed_date     = $_POST['assessed_date'] ?? '';

// Validation
$errors = [];

if (empty($competency_name)) {
    $errors[] = 'Competency name is required';
}

if (empty($category) || !in_array($category, ['Technical', 'Core', 'Soft Skills', 'Management'])) {
    $errors[] = 'Valid category is required';
}

if (!is_numeric($proficiency_level) || $proficiency_level < 1 || $proficiency_level > 5) {
    $errors[] = 'Proficiency level must be 1-5';
}

if (!is_numeric($required_level) || $required_level < 1 || $required_level > 5) {
    $errors[] = 'Required level must be 1-5';
}

if (!is_numeric($required_value) || $required_value < 1 || $required_value > 5) {
    $errors[] = 'Required value must be 1-5';
}

if (empty($assessed_date) || !strtotime($assessed_date)) {
    $errors[] = 'Valid assessment date is required';
}

if (!empty($errors)) {
    // Redirect back to form with errors
    $query = http_build_query(['error' => implode(', ', $errors)]);
    header("Location: ../../competency_form.php?$query");
    exit;
}

// Check if competency exists
$check_sql = "SELECT comp_id FROM competency_management 
              WHERE employee_id = ? AND competency_name = ? AND category = ?";
$check_stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($check_stmt, "iss", $employee_id, $competency_name, $category);
mysqli_stmt_execute($check_stmt);
$result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($result) > 0) {
    // Update
    $sql = "UPDATE competency_management 
            SET proficiency_level = ?, required_level = ?, required_value = ?, assessed_date = ?
            WHERE employee_id = ? AND competency_name = ? AND category = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiisiss", $proficiency_level, $required_level, $required_value, $assessed_date,
                          $employee_id, $competency_name, $category);
} else {
    // Insert
    $sql = "INSERT INTO competency_management 
            (employee_id, employee_name, competency_name, category, proficiency_level, required_level, required_value, assessed_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssiiis", $employee_id, $employee_name, $competency_name, $category,
                          $proficiency_level, $required_level, $required_value, $assessed_date);
}

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../competency.php?success=1");
} else {
    $query = http_build_query(['error' => 'Database error: ' . mysqli_error($conn)]);
    header("Location: ../../competency_form.php?$query");
}

// Cleanup
mysqli_stmt_close($check_stmt);
if (isset($stmt)) mysqli_stmt_close($stmt);
mysqli_close($conn);
exit;
?>
