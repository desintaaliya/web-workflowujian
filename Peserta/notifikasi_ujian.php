<?php
session_start();
include 'db.php'; // Pastikan file ini memiliki koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login_peserta.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil ID peserta dari session
$peserta_id = $_SESSION['id'];

// Query untuk mengambil notifikasi ujian yang belum dibaca
$query = "SELECT * FROM notifikasi_ujian WHERE user_id = ? AND status = 'belum dibaca' ORDER BY dibuat_pada DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = $row; // Menyimpan notifikasi dalam array
}

// Tandai sebagai sudah dibaca setelah ditampilkan
foreach ($notifications as $notification) {
    $update_query = "UPDATE notifikasi_ujian SET status = 'sudah dibaca' WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $notification['id']);
    $update_stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Notifikasi Ujian Anda</h2>

    <?php if (empty($notifications)): ?>
        <div class="alert alert-info">Anda tidak memiliki notifikasi baru.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($notification['pesan']); ?></h5>
                    <p class="mb-1">Diterima pada: <?php echo htmlspecialchars($notification['dibuat_pada']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-3 text-center">
        <a href="dashboard_peserta.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
