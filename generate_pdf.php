<?php
require 'vendor/autoload.php';
require 'db_config.php';
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Utility function for displaying styled messages
function showMessage($message, $success = true) {
    $title = $success ? "✅ Success" : "❌ Error";
    $color = $success ? "#28a745" : "#dc3545";
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$title | KUSAUTO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .message-box {
            background: white;
            border-radius: 12px;
            padding: 35px 45px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
        }
        .message-icon {
            font-size: 50px;
            color: $color;
        }
        .btn-back {
            margin-top: 25px;
            padding: 10px 25px;
            background-color: #004aad;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #00367e;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <div class="message-icon">$title</div>
        <h4 class="mt-3">$message</h4>
        <a href="index.php" class="btn-back">← Back to Form</a>
    </div>
</body>
</html>
HTML;
}

// ✅ Check Employee ID
$employee_id = $_GET['employee_id'] ?? '';
if (!$employee_id) {
    showMessage("Employee ID is required.", false);
    exit;
}

// ✅ Fetch Data from DB
$sql = "SELECT * FROM laptop_issues WHERE employee_id = :employee_id ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['employee_id' => $employee_id]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($entries)) {
    showMessage("No records found for Employee ID: $employee_id", false);
    exit;
}

// ✅ Setup PDF Save Directory
$saveDir = __DIR__ . '/generated_pdfs';
if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

$pdfFiles = [];

foreach ($entries as $index => $entry) {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetMargins(10, 8, 10);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10.5);

    $html = '
    <style>
        h3, h4, h5 { margin: 3px 0; padding: 0; }
        table { margin-top: 6px; }
    </style>

    <div style="text-align: center;">
        <h3>KUS INDIA PRIVATE LIMITED</h3>
        <h4>Laptop Issue & Return Form</h4>
    </div>

    <h5>Employee Details</h5>
    <table border="1" cellpadding="3" cellspacing="0">
        <tr><td width="30%"><b>Name</b></td><td>' . $entry['user'] . '</td></tr>
        <tr><td><b>Employee ID</b></td><td>' . $entry['employee_id'] . '</td></tr>
        <tr><td><b>Department</b></td><td>' . $entry['department'] . '</td></tr>
    </table>

    <h5>Laptop Details</h5>
    <table border="1" cellpadding="3" cellspacing="0">
        <tr><th width="10%">S.No</th><th width="45%">Item Description</th><th width="45%">Details / Remarks</th></tr>
        <tr><td>1</td><td>Laptop Make & Model</td><td>' . $entry['model'] . ' ' . $entry['intel'] . '/' . $entry['ram'] . '/' . $entry['rom'] . '/' . $entry['os'] . '</td></tr>
        <tr><td>2</td><td>Serial Number</td><td>' . $entry['asset_no'] . '</td></tr>
        <tr><td>3</td><td>Password</td><td>' . $entry['password'] . '</td></tr>
        <tr><td>4</td><td>Charger Provided</td><td>☐ Yes ☐ No</td></tr>
        <tr><td>5</td><td>Condition at Issue</td><td>☐ New ☐ Good ☐ Fair ☐ Damaged</td></tr>
        <tr><td>6</td><td>Mouse</td><td>☐ Yes ☐ No</td></tr>
        <tr><td>7</td><td>Working Condition Verified</td><td>☐ Yes ☐ No</td></tr>
        <tr><td>8</td><td>Accessories (if any)</td><td>' . $entry['short_note'] . '</td></tr>
    </table>

    <table border="0" cellpadding="3" cellspacing="0" style="margin-top: 6px;">
        <tr>
            <td><b>Laptop Issued On:</b> ____________</td>
            <td><b>Laptop Returned On:</b> ____________</td>
        </tr>
    </table>

    <h5>Condition at the Time of Return</h5>
    <table border="1" cellpadding="3" cellspacing="0">
        <tr><td><b>Item</b></td><td><b>Status</b></td><td><b>Remarks</b></td></tr>
        <tr><td>Physical Condition</td><td>☐ Good ☐ Damaged</td><td></td></tr>
        <tr><td>Charger</td><td>☐ Returned ☐ Missing</td><td></td></tr>
        <tr><td>Mouse</td><td>☐ Returned ☐ Missing</td><td></td></tr>
        <tr><td>Any Issues Reported</td><td>☐ Yes ☐ No</td><td></td></tr>
    </table>

    <h5>Signatures</h5>
    <table border="1" cellpadding="6" cellspacing="0" style="height: 100px;">
        <tr><td><b>Name</b></td><td><b>Signature</b></td></tr>
        <tr><td>IT/Asset Keeper: DHEEPAN SAKKARAVARTHI.CJS</td><td></td></tr>
        <tr><td>HOD / Employee: -</td><td></td></tr>
        <tr><td>Issued By: David Spurgeon S</td><td></td></tr>
        <tr><td>Received By:</td><td></td></tr>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $safeUser = preg_replace('/[^a-zA-Z0-9]/', '_', $entry['user']);
    $pdfName = $entry['employee_id'] . '_' . $safeUser . '_' . ($index + 1) . '_' . time() . '.pdf';
    $pdfPath = $saveDir . '/' . $pdfName;

    $pdf->Output($pdfPath, 'F');
    $pdfFiles[] = $pdfPath;
}

// ✅ Download Logic
if (count($pdfFiles) === 1) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=" . basename($pdfFiles[0]));
    readfile($pdfFiles[0]);
    exit;
} else {
    $zipName = $saveDir . '/pdf_bundle_' . $employee_id . '_' . time() . '.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE) {
        showMessage("Could not create ZIP file.", false);
        exit;
    }

    foreach ($pdfFiles as $pdfFile) {
        $zip->addFile($pdfFile, basename($pdfFile));
    }

    $zip->close();

    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=" . basename($zipName));
    header("Content-Length: " . filesize($zipName));
    readfile($zipName);
    exit;
}
?>
