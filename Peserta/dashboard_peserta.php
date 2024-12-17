<?php
session_start();

// Cek apakah peserta sudah login
if (!isset($_SESSION['id'])) {
    header('Location: login_peserta.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Koneksi ke database
include 'db.php';

// Ambil data peserta
$peserta_id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data peserta ditemukan
if ($result->num_rows > 0) {
    $peserta = $result->fetch_assoc();
} else {
    // Jika tidak ada data peserta ditemukan
    echo "Data peserta tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
        }
        .list-group-item {
            border: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        .list-group-item:hover {
            background-color: #007bff;
            color: white;
        }
        .navbar {
            border-bottom: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="#">Dashboard Peserta</a>
            <span class="navbar-text ms-auto">
                Welcome, <?php echo htmlspecialchars($peserta['username']); ?>
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <strong>Peserta Dashboard</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="notifikasi_ujian.php" class="list-group-item">Lihat Jadwal Ujian</a>
                            <a href="konfirmasi_kehadiran.php" class="list-group-item">Konfirmasi Kehadiran</a>
                            <a href="riwayat_ujian.php" class="list-group-item">Riwayat Ujian</a>
                            <a href="pendaftaran.php" class="list-group-item">Silahkan Daftar Disini</a>
                            <a href="pilih_metode.php" class="list-group-item">Pilih Metode Ujian</a>
                            <a href="notifikasi_pengelompokan.php" class="list-group-item">notifikasi pengelompokan</a>
                            <a href="logout_peserta.php" class="list-group-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
