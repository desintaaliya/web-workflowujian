<?php
session_start();
include 'db.php'; // Koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login_peserta.php");
    exit();
}

// Handle pembatalan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cancel_reason = $_POST['cancel_reason']; // Alasan pembatalan
    $peserta_id = $_SESSION['id'];

    // Update status peserta dan catat alasan pembatalan
    $update_query = "UPDATE users SET status = 'Menunggu', cancel_reason = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $cancel_reason, $peserta_id);
    $stmt->execute();

    // Kirim notifikasi ke admin
    // system_send_notification_admin_cancel_request($peserta_id, $cancel_reason);

    // Redirect setelah permohonan pembatalan
    header("Location: dashboard_peserta.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembatalan Ujian</title>
</head>
<body>
    <h2>Pembatalan Ujian</h2>
    <form method="POST">
        <label for="cancel_reason">Alasan Pembatalan:</label>
        <textarea name="cancel_reason" id="cancel_reason" required></textarea><br>

        <button type="submit">Kirim Pembatalan</button>
    </form>
</body>
</html>
