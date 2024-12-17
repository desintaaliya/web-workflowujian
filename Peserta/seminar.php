<?php 
session_start(); 
require 'db.php';  

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {     
    header('Location: login_pelaksanaan_ujian.php');     
    exit; 
} 
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Seminar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 800px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h1>Ujian Seminar</h1>
            </div>
            <div class="card-body">
                <p class="text-center">
                    Silakan unggah materi presentasi Anda sebelum seminar dimulai.
                </p>

                <!-- Form unggah materi presentasi -->
                <form method="POST" action="upload_materi.php" enctype="multipart/form-data" class="mt-4">
                    <div class="mb-3">
                        <label for="materi" class="form-label">Pilih Materi Presentasi (PDF/PowerPoint):</label>
                        <input type="file" class="form-control" name="materi" id="materi" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Unggah Materi</button>
                    </div>
                </form>

                <hr>
                <p class="text-muted mt-4">
                    Setelah presentasi, sesi tanya jawab akan dimulai. Penguji akan memberikan penilaian berdasarkan
                    presentasi dan jawaban Anda selama sesi tanya jawab.
                </p>

                <!-- Tombol Kembali ke Pelaksanaan Ujian -->
                <div class="text-center mt-4">
                    <a href="pelaksanaan_ujian.php" class="btn btn-secondary btn-lg">Kembali ke Pelaksanaan Ujian</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
