<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $title = $_POST['lesson_title'];
    $file = $_FILES['lesson_file']['name'];
    $tmp = $_FILES['lesson_file']['tmp_name'];
    $path = "uploads/lessons/" . $file;

    if (!is_dir("uploads/lessons")) mkdir("uploads/lessons", 0777, true);

    if (move_uploaded_file($tmp, $path)) {
        $stmt = $conn->prepare("INSERT INTO lessons (lesson_title, lesson_file) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $file);
        $stmt->execute();
        $stmt->close();
        $message = "Lesson uploaded successfully!";
    } else {
        $message = "Upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Upload Lesson</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl font-bold mb-4">Upload Lesson</h1>

  <?php if(isset($message)) echo "<p class='text-green-600 mb-2'>$message</p>"; ?>

  <form method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="lesson_title" placeholder="Lesson Title" class="input input-bordered w-full" required>
    <input type="file" name="lesson_file" class="file-input file-input-bordered w-full" required>
    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
  </form>
</body>
</html>
