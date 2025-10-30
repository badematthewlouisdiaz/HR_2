<?php
session_start();
include("../db.php");

if(!isset($_SESSION['uploaded_pdf'])){
    header("Location: index.php");
    exit;
}

$pdfPath = $_SESSION['uploaded_pdf'];

// ✅ TODO: Parse PDF & generate questions here
// For now, insert sample question into DB

$sql = "INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_answer) 
        VALUES ('What is TANu AI?', 'A Tool', 'An AI', 'A Database', 'A Framework', 'B')";
$conn->query($sql);

header("Location: exam.php");
exit;
?>
