<?php
session_start();

if(isset($_FILES['pdf_file'])){
    $targetDir = "uploads/";
    $fileName = basename($_FILES["pdf_file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if(move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFilePath)){
        $_SESSION['uploaded_pdf'] = $targetFilePath;
        header("Location: generate.php");
        exit;
    } else {
        echo "Error uploading file.";
    }
}
?>
