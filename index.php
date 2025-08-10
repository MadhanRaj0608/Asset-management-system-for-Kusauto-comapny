<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KUSAUTO | Laptop /title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #e9eff5 100%);
            padding-top: 40px;
        }

        .container {
            max-width: 1080px;
        }

        .form-section {
            background-color:transparent;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 18px rgba(0, 0, 0, 0.06);
            margin-bottom: 40px;
        }

        .kus-logo {
            height: 70px;
            object-fit: contain;
        }

        .form-label {
            font-weight: 600;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 20px;
            border-left: 4px solid #004aad;
            padding-left: 12px;
            color: #004aad;
        }

        .btn-custom {
            background-color: #004aad;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #00367e;
        }

        input[type="text"], input[type="file"] {
            border-radius: 6px;
        }

        .text-muted {
            font-size: 0.95rem;
        }

        .text-end .btn {
            min-width: 180px;
        }

        @media (max-width: 576px) {
            .text-end {
                text-align: center !important;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- ✅ KUSAUTO Logo & Title -->
    <div class="text-center mb-5">
        <img src="download.jpeg" class="kus-logo" alt="KUS Logo">
        <h2 class="mt-2 fw-bold text-dark">Laptop Issue & Return Form</h2>
        <p class="text-muted">KUSAUTO Company Internal IT Management</p>
    </div>

    <!-- ✅ Main Form Section -->
    <div class="form-section">
        <div class="section-title">📝 Enter Laptop Issue Details</div>
        <form action="save_data.php" method="post">
            <div class="row">
                <?php
                $fields = [
                    'slno' => 'SL. No', 'type' => 'Type', 'purchase_date' => 'Purchase Date', 'short_note' => 'Short Note',
                    'model' => 'Model', 'it_no' => 'IT No', 'intel' => 'Intel', 'ram' => 'RAM', 'rom' => 'ROM', 'os' => 'OS',
                    'cc' => 'CC', 'asset_no' => 'Asset No (Serial Number)', 'user' => 'User Name',
                    'employee_id' => 'Employee ID', 'department' => 'Department', 'user_id' => 'User ID',
                    'password' => 'Password', 'remarks' => 'Remarks'
                ];

                foreach ($fields as $name => $label) {
                    echo '<div class="col-md-6 mb-3">
                            <label for="' . $name . '" class="form-label">' . $label . '</label>
                            <input type="text" class="form-control" name="' . $name . '" id="' . $name . '" required>
                          </div>';
                }
                ?>
            </div>
            <div class="text-end mt-4">
                <button type="submit" name="submit" class="btn btn-custom">💾 Submit & Save to Excel</button>
            </div>
        </form>
    </div>

    <!-- ✅ PDF Generator Section -->
    <div class="form-section">
        <div class="section-title">📄 Generate PDF by Employee ID</div>
        <form action="generate_pdf.php" method="get" class="row g-3">
            <div class="col-md-6">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" name="employee_id" id="employee_id" class="form-control" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-custom w-100">📤 Generate PDF</button>
            </div>
        </form>
    </div>

    <!-- ✅ Upload Signed PDF Section -->
    <div class="form-section">
        <div class="section-title">📤 Upload Signed PDF (IT Number)</div>
        <form action="upload_pdf.php" method="post" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="it_no" class="form-label">Enter IT Number</label>
                <input type="text" name="it_no" id="it_no" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="pdf_file" class="form-label">Upload PDF File</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf" required>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-custom">⬆️ Upload PDF</button>
            </div>
        </form>
    </div>

</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
