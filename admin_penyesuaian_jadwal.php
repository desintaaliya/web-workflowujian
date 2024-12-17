<?php
session_start();
include 'db.php'; // Koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data peserta yang perlu penyesuaian
$query = "SELECT * FROM users WHERE attendance_status = 'declined'"; // Peserta yang menolak kehadiran
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update jadwal ujian
    $new_exam_date = $_POST['exam_date'];
    $new_exam_time = $_POST['exam_time'];
    $update_query = "UPDATE users SET exam_date = ?, exam_time = ? WHERE attendance_status = 'declined'";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ss", $new_exam_date, $new_exam_time);
    $stmt->execute();

    // Kirim notifikasi ke peserta tentang perubahan jadwal
    // system_send_notification_to_all_declined($new_exam_date, $new_exam_time);
    header("Location: dashboard_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyesuaian Jadwal</title>
</head>
<body>
    <h2>Penyesuaian Jadwal Ujian</h2>
    <form method="POST">
        <label for="exam_date">Tanggal Ujian Baru:</label>
        <input type="date" name="exam_date" id="exam_date" required><br>
        
        <label for="exam_time">Waktu Ujian Baru:</label>
        <input type="time" name="exam_time" id="exam_time" required><br>
        
        <button type="submit">Update Jadwal</button>
    </form>

    <h3>Peserta yang Menolak Kehadiran:</h3>
    <table>
        <tr>
            <th>Nama Peserta</th>
            <th>Status Kehadiran</th>
        </tr>
        <?php while($peserta = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($peserta['username']); ?></td>
                <td><?php echo $peserta['attendance_status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
