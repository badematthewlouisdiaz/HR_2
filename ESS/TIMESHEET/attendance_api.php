<?php
// attendance_api.php
session_start();
include 'db_connect.php'; // Setup $conn = new mysqli(...)
// Get user ID from session (adjust as needed)
$user_id = $_SESSION['user_id'] ?? 1; // fallback for demo

function get_shift_for_date($conn, $user_id, $date) {
    // If your events table has user_id, use it, else remove user_id filter
    $stmt = $conn->prepare("SELECT start_time FROM events WHERE event_date=? AND type='Shift' LIMIT 1");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

function get_status($clock_in, $shift_start) {
    if (!$clock_in || !$shift_start) return "";
    // Compare times in H:i:s format
    return ($clock_in <= $shift_start) ? "On Time" : "Late";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action == 'clockin') {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        // Prevent multiple clock-ins
        $stmt = $conn->prepare("SELECT id FROM attendance WHERE user_id=? AND date=?");
        $stmt->bind_param("is", $user_id, $date);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO attendance (user_id, date, clock_in) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $date, $time);
            $stmt->execute();
            echo json_encode(["success"=>true, "clock_in"=>$time]);
        } else {
            echo json_encode(["success"=>false, "error"=>"Already clocked in today"]);
        }
        exit;
    }
    if ($action == 'clockout') {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $stmt = $conn->prepare("UPDATE attendance SET clock_out=?, status='Approved' WHERE user_id=? AND date=? AND clock_out IS NULL");
        $stmt->bind_param("sis", $time, $user_id, $date);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success"=>true, "clock_out"=>$time]);
        } else {
            echo json_encode(["success"=>false, "error"=>"Already clocked out or not clocked in"]);
        }
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];
    if ($action == 'today') {
        $date = date('Y-m-d');
        $result = $conn->query("SELECT * FROM attendance WHERE user_id=$user_id AND date='$date'");
        $row = $result->fetch_assoc();
        $shift = get_shift_for_date($conn, $user_id, $date);
        $row['shift_start'] = $shift ? $shift['start_time'] : null;
        $row['status'] = get_status($row['clock_in'] ?? null, $row['shift_start']);
        echo json_encode($row);
        exit;
    }
    if ($action == 'history') {
        // Get last 7 days
        $result = $conn->query("SELECT * FROM attendance WHERE user_id=$user_id ORDER BY date DESC LIMIT 7");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $shift = get_shift_for_date($conn, $user_id, $row['date']);
            $row['shift_start'] = $shift ? $shift['start_time'] : null;
            $row['status'] = get_status($row['clock_in'] ?? null, $row['shift_start']);
            $rows[] = $row;
        }
        echo json_encode($rows);
        exit;
    }
    // Add more actions as needed for month/year
}
?>