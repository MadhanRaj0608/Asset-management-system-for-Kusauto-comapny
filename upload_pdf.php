<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'laptopdetails';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $it_no = $_POST['it_no'];
    $pdf = $_FILES['pdf_file'];

    // Check if IT number exists
    $check = $conn->query("SELECT * FROM laptop_issues WHERE it_no = '$it_no'");
    if ($check->num_rows === 0) {
        die("❌ IT Number not found in database.");
    }

    // Prepare to upload
    $filename = uniqid("pdf_") . "_" . basename($pdf['name']);
    $upload_dir = "uploads/";
    $upload_path = $upload_dir . $filename;

    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    if (move_uploaded_file($pdf['tmp_name'], $upload_path)) {
        // Update DB
        $stmt = $conn->prepare("UPDATE laptop_issues SET pdf_file = ? WHERE it_no = ?");
        $stmt->bind_param("ss", $upload_path, $it_no);
        $stmt->execute();
        echo "✅ PDF uploaded and linked successfully.";
    } else {
        echo "❌ Failed to upload file.";
    }
}
?>
