<?php
session_start();
require 'db.php';  // Pastikan Anda menghubungkan dengan database jika perlu untuk penyimpanan

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

// Cek jika file materi sudah ada di direktori
$target_dir = "uploads/";  // Tentukan folder tempat menyimpan file
$uploaded_files = glob($target_dir . "*.{pdf,ppt,pptx}", GLOB_BRACE);  // Mencari file dengan ekstensi pdf, ppt, pptx

if (count($uploaded_files) > 0) {
    $file_link = "<a href='" . $uploaded_files[0] . "' target='_blank' class='btn btn-info mt-3'>Klik di sini untuk melihat materi</a>";
    $file_name = basename($uploaded_files[0]);
} else {
    $file_link = null;
    $file_name = null;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Presentasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 60px;
            max-width: 900px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #6f42c1;
            color: white;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .alert {
            border-radius: 8px;
        }

        .btn-primary, .btn-secondary {
            text-transform: uppercase;
            font-weight: 600;
        }

        .text-center {
            margin-top: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Materi Presentasi</h2>
            </div>
            <div class="card-body">
                <p class="text-center mb-4">Berikut adalah materi yang sudah diunggah:</p>

                <?php if ($file_link): ?>
                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">Materi yang Diupload:</h5>
                        <p>File yang diunggah: <strong><?php echo $file_name; ?></strong></p>
                        <?php echo $file_link; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        <h5 class="alert-heading">Belum ada materi yang diunggah</h5>
                        <p>Materi presentasi belum tersedia. Silakan coba lagi nanti.</p>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="pelaksanaan_ujian.php" class="btn btn-secondary btn-lg">Kembali ke Pelaksanaan Ujian</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
