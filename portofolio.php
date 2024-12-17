<?php
session_start();
require 'db.php';

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengecek apakah file diupload
    if (isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] == 0) {
        $allowed_types = ['pdf', 'docx', 'zip'];
        $file_name = $_FILES['portofolio']['name'];
        $file_tmp_name = $_FILES['portofolio']['tmp_name'];
        $file_size = $_FILES['portofolio']['size'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $target_dir = "uploads/"; // Pastikan folder uploads sudah ada
        $target_file = $target_dir . basename($file_name);

        // Validasi ekstensi file
        if (in_array(strtolower($file_ext), $allowed_types)) {
            // Cek ukuran file (maksimal 5MB)
            if ($file_size <= 5 * 1024 * 1024) {
                // Pindahkan file ke folder tujuan
                if (move_uploaded_file($file_tmp_name, $target_file)) {
                    // Menggunakan Bootstrap untuk feedback
                    echo '<div class="alert alert-success" role="alert">Portofolio berhasil diunggah!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Maaf, terjadi kesalahan saat mengupload file.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Ukuran file terlalu besar. Maksimal 5MB.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Ekstensi file tidak valid. Hanya PDF, DOCX, atau ZIP yang diperbolehkan.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Tidak ada file yang diupload.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Portofolio</title>
    <!-- Bootstrap CSS -->
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
                <h1>Unggah Portofolio</h1>
            </div>
            <div class="card-body">
                <p class="text-center">
                    Unggah portofolio Anda untuk dinilai oleh penguji.
                </p>

                <!-- Form unggah portofolio -->
                <form method="POST" action="upload_portofolio.php" enctype="multipart/form-data" class="mt-4">
                    <div class="mb-3">
                        <label for="portofolio" class="form-label">Pilih Portofolio (PDF, DOCX, ZIP):</label>
                        <input type="file" class="form-control" name="portofolio" id="portofolio" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Unggah Portofolio</button>
                    </div>
                </form>

                <hr>

                <h5 class="mt-4">Penilaian Penguji</h5>
                <p class="text-muted">Portofolio Anda akan dinilai sesuai dengan kriteria berikut:</p>
                <ul>
                    <li>Keselarasan dengan topik</li>
                    <li>Keunikan dan orisinalitas</li>
                    <li>Kompleksitas dan kedalaman konten</li>
                    <li>Kualitas penyajian dan format</li>
                </ul>

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
