<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Koneksi ke database
include 'db.php';

// Ambil data admin
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .card-header {
            background-color: #4CAF50;
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
            background-color: #4CAF50;
            color: white;
        }
        .navbar {
            border-bottom: 2px solid #ddd;
        }
        .navbar .navbar-brand {
            font-weight: bold;
        }
        .navbar .navbar-text {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="#">Dashboard Admin</a>
            <span class="navbar-text ms-auto">
                Welcome, <?php echo htmlspecialchars($admin['username']); ?>
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <strong>Admin Dashboard</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="verifikasi_peserta.php" class="list-group-item">Verifikasi Peserta</a>
                            <a href="pengelompokan_peserta.php" class="list-group-item">Pengelompokan Peserta</a>
                            <a href="penunjukan_penguji.php" class="list-group-item">Penunjukan Penguji</a>
                            <a href="dashboard_kelas.php" class="list-group-item">Dashboard Kelas</a>
                            <a href="daftar_peserta.php" class="list-group-item">Daftar Peserta</a>
                            <a href="logout_admin.php" class="list-group-item">Logout</a>
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
