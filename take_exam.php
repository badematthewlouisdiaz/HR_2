<?php
include 'db.php';
$exam_id = $_GET['exam_id'] ?? 0;
$exam = $conn->query("SELECT * FROM exams WHERE exam_id=$exam_id")->fetch_assoc();
$questions = $conn->query("SELECT * FROM questions WHERE exam_id=$exam_id")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Take Exam</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet">
</head>
<body class="p-6">
<h1 class="text-2xl font-bold mb-4"><?= $exam['exam_title'] ?></h1>

<form action="submit_exam.php" method="post" class="space-y-4">
<input type="hidden" name="exam_id" value="<?= $exam_id ?>">
<?php foreach($questions as $i => $q): ?>
<div class="card bg-base-100 shadow p-4">
    <p class="font-semibold"><?= ($i+1) ?>. <?= $q['question_text'] ?></p>
    <?php if($q['question_type']=='mcq'): 
        $choices = json_decode($q['choices']);
        foreach($choices as $c): ?>
        <label class="block"><input type="radio" name="q<?= $q['question_id'] ?>" value="<?= $c ?>"> <?= $c ?></label>
    <?php endforeach; 
    elseif($q['question_type']=='true_false'): ?>
        <label class="block"><input type="radio" name="q<?= $q['question_id'] ?>" value="True"> True</label>
        <label class="block"><input type="radio" name="q<?= $q['question_id'] ?>" value="False"> False</label>
    <?php else: ?>
        <textarea name="q<?= $q['question_id'] ?>" class="textarea textarea-bordered w-full"></textarea>
    <?php endif; ?>
</div>
<?php endforeach; ?>
<button type="submit" class="btn btn-success mt-4">Submit Exam</button>
</form>
</body>
</html>
