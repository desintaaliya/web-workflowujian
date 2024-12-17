<?php
session_start();
require 'db.php';

// Cek apakah ada notifikasi di session
if (!isset($_SESSION['notifikasi'])) {
    // Jika tidak ada, redirect ke halaman pengelompokan
    header("Location: ../pengelompokan.php");
    exit();
}

// Ambil notifikasi dari session
$notifikasi = $_SESSION['notifikasi'];

// Hapus notifikasi setelah ditampilkan
unset($_SESSION['notifikasi']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengelompokan</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .btn-primary {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card untuk menampilkan notifikasi -->
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Notifikasi Pengelompokan Peserta</h4>
                </div>
                <div class="card-body">
                    <!-- Menampilkan notifikasi -->
                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">Pemberitahuan</h5>
                        <p><?php echo $notifikasi; ?></p>
                        <hr>
                        <p class="mb-0">Silakan periksa aplikasi untuk informasi lebih lanjut mengenai jadwal ujian Anda.</p>
                    </div>
                    <!-- Tombol Kembali -->
                    <div class="d-grid gap-2">
                        <a href="daftar_peserta.php" class="btn btn-primary btn-lg">Kembali ke Daftar Peserta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Link Bootstrap 5 JS dan Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
