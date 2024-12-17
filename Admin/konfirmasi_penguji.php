<?php
// Mulai session dan koneksi ke database
session_start();
include 'db.php'; // Pastikan Anda memiliki file koneksi db.php

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data penunjukan penguji
$penguji_id = $_SESSION['penguji_id'];  // ID penguji yang sudah login
$query = "SELECT * FROM penunjukan_penguji WHERE penguji_id = ? AND status = 'Menunggu Konfirmasi'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $penguji_id);
$stmt->execute();
$result = $stmt->get_result();
$penunjukan = $result->fetch_assoc();

// Proses konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $konfirmasi = $_POST['konfirmasi'];

    if ($konfirmasi === 'Bisa') {
        $update_query = "UPDATE penunjukan_penguji SET status = 'Dikonfirmasi' WHERE id = ?";
    } else {
        $update_query = "UPDATE penunjukan_penguji SET status = 'Ditolak' WHERE id = ?";
    }

    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $penunjukan['id']);
    $update_stmt->execute();

    // Kirim notifikasi kepada admin
    $_SESSION['notifikasi'] = "Penguji telah mengonfirmasi keikutsertaannya untuk ujian pada kloter {$penunjukan['kloter_ujian']}.";
    echo "<script>alert('Konfirmasi berhasil.'); window.location.href='dashboard_notifikasi.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Penunjukan Penguji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Konfirmasi Penunjukan Penguji</h2>
    <?php if ($penunjukan): ?>
        <p>Anda telah ditunjuk sebagai penguji untuk kloter ujian: <?php echo $penunjukan['kloter_ujian']; ?></p>
        <form method="POST">
            <div class="mb-3">
                <label for="konfirmasi" class="form-label">Apakah Anda akan hadir sebagai penguji?</label>
                <select name="konfirmasi" id="konfirmasi" class="form-select" required>
                    <option value="Bisa">Bisa</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </form>
    <?php else: ?>
        <p>Anda tidak memiliki penunjukan penguji saat ini.</p>
    <?php endif; ?>
</div>
</body>
</html>
