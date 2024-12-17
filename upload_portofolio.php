<?php
session_start();
require 'db.php';

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

$uploaded_file = ""; // Menyimpan nama file yang diunggah

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
                    $uploaded_file = $target_file; // Menyimpan path file yang diunggah
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
                <h1>Hasil Portofolio Yang Di Unggah</h1>
            </div>
                <?php if ($uploaded_file): ?>
                    <!-- Menampilkan file yang diunggah -->
                    <div class="alert alert-success mt-4" role="alert">
                        Portofolio berhasil diunggah! <br>
                        <strong>Nama file:</strong> <?php echo basename($uploaded_file); ?> <br>
                        <a href="<?php echo $uploaded_file; ?>" class="btn btn-info mt-2" target="_blank">Lihat Portofolio</a>
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
