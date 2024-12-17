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
    <title>Ujian Praktikum</title>
    <!-- Link CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #2c3e50;
            color: #fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-footer {
            background-color: #ecf0f1;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .navbar {
            background-color: #3498db;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .footer {
            background-color: #34495e;
            color: white;
            padding: 20px 0;
        }

        .text-primary-custom {
            color: #3498db;
        }

        .card-body ul {
            list-style: none;
            padding: 0;
        }

        .card-body ul li {
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-body ul li strong {
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <!-- Container utama -->
    <div class="container my-5">
        <!-- Bagian Judul -->
        <div class="text-center mb-4">
            <h1 class="display-4 text-primary-custom">Ujian Praktikum</h1>
            <p class="lead text-secondary">Ikuti instruksi berikut untuk ujian praktikum Anda:</p>
        </div>

        <!-- Card untuk instruksi ujian praktikum -->
        <div class="card shadow-lg">
            <div class="card-header">
                <h5 class="card-title mb-0">Instruksi Ujian Praktikum</h5>
            </div>
            <div class="card-body">
                <!-- List instruksi -->
                <ul>
                    <li><strong>Instruksi 1:</strong> Ambil sampel bahan praktikum yang telah disediakan.</li>
                    <li><strong>Instruksi 2:</strong> Lakukan eksperimen sesuai prosedur yang diberikan.</li>
                    <li><strong>Instruksi 3:</strong> Catat hasil eksperimen Anda dan siapkan laporan.</li>
                </ul>
            </div>
            <div class="card-footer text-center text-muted">
                <p>Penguji akan menilai langsung berdasarkan performa Anda selama praktikum.</p>
                <p class="fw-bold">Selamat menjalankan praktikum!</p>
            </div>
        </div>

        <!-- Tombol Kembali ke Pelaksanaan Ujian -->
        <div class="text-center mt-4">
            <a href="pelaksanaan_ujian.php" class="btn btn-secondary btn-lg">Kembali ke Pelaksanaan Ujian</a>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
