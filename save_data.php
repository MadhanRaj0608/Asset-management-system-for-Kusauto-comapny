<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submission Status | KUSAUTO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap 5 & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .success-card {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            text-align: center;
        }

        .success-card h2 {
            color: #004aad;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .btn-back {
            background-color: #004aad;
            color: white;
            padding: 10px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #00367e;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">✅</div>
    <h2>Submission Successful</h2>
    <p class="text-muted">The laptop issue details have been securely saved to our records and stored in both Excel and the internal database.</p>
    <a href="index.php" class="btn-back mt-3">← Back to Form</a>
</div>

</body>
</html>
