<?php
session_start();
include("db.php");

$questions = $conn->query("SELECT * FROM questions ORDER BY RAND() LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>TANu AI Exam</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">
  <form action="result.php" method="post" class="space-y-6">
    <h2 class="text-xl font-bold mb-4">📖 TANu AI Exam</h2>
    <?php while($q = $questions->fetch_assoc()): ?>
      <div class="card bg-white shadow-md p-4 rounded-xl">
        <p class="font-semibold"><?= $q['question']; ?></p>
        <div class="mt-2 space-y-2">
          <?php foreach(['a','b','c','d'] as $opt): ?>
            <label class="flex items-center gap-2">
              <input type="radio" name="q<?= $q['id']; ?>" value="<?= strtoupper($opt); ?>" required>
              <?= $q['option_'.$opt]; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endwhile; ?>
    <button type="submit" class="btn btn-success w-full">Submit</button>
  </form>
</body>
</html>
