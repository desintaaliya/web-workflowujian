<?php
session_start();

// Cek apakah penguji sudah login
if (!isset($_SESSION['penguji_id'])) {
    header('Location: login_penguji.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Koneksi ke database
include 'db.php';

// Ambil data penguji
$penguji_id = $_SESSION['penguji_id'];
$query = "SELECT * FROM penguji WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $penguji_id);
$stmt->execute();
$result = $stmt->get_result();
$penguji = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penguji</title>
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
            background-color: #28a745;
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
            background-color: #28a745;
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
            <a class="navbar-brand ms-3" href="#">Dashboard Penguji</a>
            <span class="navbar-text ms-auto">
                Welcome, <?php echo htmlspecialchars($penguji['username']); ?>
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <strong>Penguji Dashboard</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="penilaian_ujian.php" class="list-group-item">Penilaian Ujian</a>
                            <a href="jadwal_penguji.php" class="list-group-item">Jadwal Ujian</a>
                            <a href="riwayat_penguji.php" class="list-group-item">Riwayat Penilaian</a>
                            <a href="konfirmasi_notifikasi.php" class="list-group-item">Konfirmasi Notifikasi Penunjukan</a>
                            <a href="Notifikasi_penunjukan.php" class="list-group-item">Konfirmasi Notifikasi Penunjukan</a>
                            <a href="logout_penguji.php" class="list-group-item">Logout</a>

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
