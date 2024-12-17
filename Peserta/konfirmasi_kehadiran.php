<?php
session_start();
include 'db.php'; // Koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login_peserta.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil ID peserta dari session
$peserta_id = $_SESSION['id'];

// Cek data peserta
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();  // Menyimpan data peserta dalam variabel $peserta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_kehadiran = $_POST['status_kehadiran']; // 'Hadir' or 'Dibatalkan'

    // Update status kehadiran peserta
    $update_query = "UPDATE users SET status_kehadiran = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status_kehadiran, $peserta_id);
    $stmt->execute();

    // Kirimkan notifikasi jika kehadiran dikonfirmasi
    if ($status_kehadiran == 'Hadir') {
        // Buat pesan notifikasi
        $exam_schedule = "Jadwal ujian Anda: Tanggal, Waktu, Lokasi"; // Ganti dengan data nyata
        $notification_query = "INSERT INTO notifikasi_ujian (user_id, pesan) VALUES (?, ?)";
        $stmt = $conn->prepare($notification_query);
        $stmt->bind_param("is", $peserta_id, $exam_schedule);
        $stmt->execute();

        // Redirect ke pelaksanaan_ujian.php setelah konfirmasi
        header("Location: pelaksanaan_ujian.php");
        exit();
    } else {
        // Jika memilih "Tidak", status peserta menjadi "Menunggu"
        $update_status_query = "UPDATE users SET status = 'Menunggu' WHERE id = ?";
        $stmt = $conn->prepare($update_status_query);
        $stmt->bind_param("i", $peserta_id);
        $stmt->execute();

        // Kirimkan notifikasi bahwa peserta dipindahkan ke status "Menunggu"
        $waiting_notification = "Anda tidak hadir pada ujian ini dan dipindahkan ke status 'Menunggu'. Anda akan diberi jadwal ujian berikutnya.";
        $notification_query = "INSERT INTO notifikasi_ujian (user_id, pesan) VALUES (?, ?)";
        $stmt = $conn->prepare($notification_query);
        $stmt->bind_param("is", $peserta_id, $waiting_notification);
        $stmt->execute();
    }

    // Redirect ke halaman notifikasi_ujian.php setelah konfirmasi
    header("Location: pelaksanaan_ujian.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Kehadiran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Konfirmasi Kehadiran</h2>

    <div class="card shadow-lg">
        <div class="card-header text-center">
            <strong>Apakah Anda akan hadir pada ujian?</strong>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <p>Peserta: <?php echo htmlspecialchars($peserta['username']); ?></p>
                    <p>Silakan pilih status kehadiran Anda:</p>
                </div>
                <div class="mb-3">
                    <button type="submit" name="status_kehadiran" value="Hadir" class="btn btn-success w-100">Iya</button>
                </div>
                <div class="mb-3">
                    <button type="submit" name="status_kehadiran" value="Dibatalkan" class="btn btn-danger w-100">Tidak</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="dashboard_peserta.php">Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
