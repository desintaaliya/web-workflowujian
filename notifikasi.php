<?php
// Koneksi ke database
include 'db.php';

// Ambil semua notifikasi untuk peserta yang login
$peserta_id = $_SESSION['peserta_id'];
$query = "SELECT pesan, tanggal FROM notifikasi WHERE peserta_id = '$peserta_id' ORDER BY tanggal DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Notifikasi Anda</h2>
    <ul class="list-group">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <p><strong><?php echo $row['pesan']; ?></strong></p>
                    <small>Diterima pada: <?php echo date('d M Y, H:i', strtotime($row['tanggal'])); ?></small>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li class="list-group-item">Tidak ada notifikasi untuk Anda.</li>
        <?php endif; ?>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
