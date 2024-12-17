<?php
session_start();// Mulai session
include 'db.php';// Koneksi ke database

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data peserta yang sudah diverifikasi
$query = "SELECT * FROM peserta WHERE status_verifikasi = 'Lolos'";
$result = $conn->query($query);
$peserta = $result->fetch_all(MYSQLI_ASSOC);

// Proses pengelompokan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kloter_id = $_POST['kloter_id']; // ID kloter ujian
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];

    // Update pengelompokan peserta
    foreach ($_POST['peserta_id'] as $peserta_id) {
        $update_query = "UPDATE peserta SET kloter_id = ?, tanggal_ujian = ?, waktu_ujian = ?, lokasi_ujian = ? WHERE id = ?";
        
        // Pastikan tipe data yang benar di bind_param, misalnya: s (string) untuk kloter_id, tanggal, waktu, lokasi, dan i (integer) untuk peserta_id
        $stmt = $conn->prepare($update_query);

        // bind_param diubah sesuai dengan tipe data yang benar
        $stmt->bind_param("ssssi", $kloter_id, $tanggal, $waktu, $lokasi, $peserta_id);
        
        if (!$stmt->execute()) {
            // Menangani error jika query tidak dapat dieksekusi
            echo "Error: " . $stmt->error;
        }
    }

    // Kirimkan notifikasi ke peserta
    $_SESSION['notifikasi'] = "Jadwal ujian Anda telah ditentukan, silakan periksa aplikasi.";

    // Redirect ke halaman notifikasi_pengelompokan.php di folder peserta
    header("Location:../peserta/notifikasi_pengelompokan.php");
    exit(); // Jangan lupa exit untuk mencegah proses lebih lanjut
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelompokan Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Pengelompokan Peserta</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="kloter_id" class="form-label">ID Kloter Ujian</label>
            <input type="text" id="kloter_id" name="kloter_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Ujian</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="waktu" class="form-label">Waktu Ujian</label>
            <input type="time" id="waktu" name="waktu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Ujian</label>
            <input type="text" id="lokasi" name="lokasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="peserta_id" class="form-label">Peserta yang Dikelompokkan</label>
            <select id="peserta_id" name="peserta_id[]" class="form-select" multiple required>
                <?php foreach ($peserta as $row) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan Pengelompokan</button>
    </form>
</div>
</body>
</html>
