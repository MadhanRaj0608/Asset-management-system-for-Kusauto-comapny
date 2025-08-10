<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'laptopdetails';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$it_no = $_GET['it_no'] ?? '';

if ($it_no == '') {
    echo "❗ Please provide an IT number using `view.php?it_no=XXXX`.";
    exit;
}

$result = $conn->query("SELECT * FROM laptop_issues WHERE it_no = '$it_no'");
if ($result->num_rows === 0) {
    echo "❌ IT Number not found.";
    exit;
}

$row = $result->fetch_assoc();
echo "<h3>PDF for IT No: $it_no</h3>";
if (!empty($row['pdf_file']) && file_exists($row['pdf_file'])) {
    echo "<iframe src='{$row['pdf_file']}' width='100%' height='600px'></iframe>";
} else {
    echo "⚠️ PDF not uploaded yet for this IT number.";
}
?>
