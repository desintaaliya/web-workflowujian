<?php
session_start();
require 'db.php';  // Koneksi ke database

$id = $_SESSION['id']; // Ambil ID peserta dari session

// Ambil soal dan jawaban dari database
$query = "SELECT * FROM soal";
$result = mysqli_query($conn, $query);

$total_benar = 0; // Hitung jumlah jawaban benar
$total_soal = mysqli_num_rows($result); // Total soal yang diujikan

while ($soal = mysqli_fetch_assoc($result)) {
    $soal_id = $soal['id'];
    $jawaban_benar = $soal['jawaban_benar']; // Misalnya kolom untuk jawaban yang benar di database adalah 'jawaban_benar'

    // Ambil jawaban peserta dari form
    $jawaban_peserta = isset($_POST['soal_' . $soal_id]) ? $_POST['soal_' . $soal_id] : '';

    // Periksa apakah jawaban peserta sesuai dengan jawaban benar
    if ($jawaban_peserta == $jawaban_benar) {
        $total_benar++;
    }
}

// Hitung nilai ujian
$nilai = ($total_soal > 0) ? ($total_benar / $total_soal) * 100 : 0;

// Tentukan status kelulusan
$statusLulus = ($nilai >= 70) ? 'lulus' : 'tidak lulus';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian - Permenpan RB No. 2</title>
    <!-- Link Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-gradient {
            background: linear-gradient(145deg, #6c757d, #0B8494);
            border-radius: 20px;
        }
        .alert-success-custom {
            background-color: #28a745;
            color: white;
        }
        .alert-danger-custom {
            background-color: #dc3545;
            color: white;
        }
        .btn-custom {
            background-color: #125B9A;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .card-body {
            border-radius: 15px;
        }
        .card-header {
            font-size: 24px;
            font-weight: bold;
        }
        .fs-4 {
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card card-gradient shadow-lg">
            <div class="card-header text-center text-white">
                <h1>Hasil Ujian</h1>
            </div>
            <div class="card-body text-center text-white">
                <p class="fs-4">Jumlah jawaban benar: <strong><?php echo $total_benar; ?></strong></p>
                <p class="fs-4">Nilai Anda: <strong><?php echo number_format($nilai, 2); ?></strong></p>

                <!-- Alert Dinamis untuk Lulus/Tidak Lulus -->
                <div id="hasilUjian" class="d-flex justify-content-center">
                    <?php if ($statusLulus === 'lulus'): ?>
                        <div class="alert alert-success-custom d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <span>Selamat, Anda <strong>lulus</strong> ujian!</span>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger-custom d-flex align-items-center" role="alert">
                            <i class="bi bi-x-circle me-2"></i>
                            <span>Maaf, Anda <strong>tidak lulus</strong> ujian.</span>
                        </div>
                    <?php endif; ?>
                </div>

                <a href="pelaksanaan_ujian.php" class="btn btn-custom btn-lg">Kembali ke pelaksanaan ujian</a>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
