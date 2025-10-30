<?php
include 'db.php';

$exam_id = $_POST['exam_id'];
$user_id = 1; // demo user, replace with session user
$questions = $conn->query("SELECT * FROM questions WHERE exam_id=$exam_id")->fetch_all(MYSQLI_ASSOC);

$total = count($questions);
$correct = 0;

foreach($questions as $q){
    $ans = $_POST['q'.$q['question_id']] ?? '';
    if($q['question_type'] != 'essay' && strtolower($ans) == strtolower($q['correct_answer'])){
        $correct++;
    }
}

// Simple scoring
$score = ($correct/$total)*100;

$stmt = $conn->prepare("INSERT INTO results (user_id, exam_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $user_id, $exam_id, $score);
$stmt->execute();
$stmt->close();

echo "Exam submitted! Your score: $score%";
