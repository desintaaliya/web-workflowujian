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

// Ambil data dari form (misalnya jenis ujian, tanggal ujian, waktu ujian, lokasi, dll.)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_ujian = $_POST['jenis_ujian'];
    $tanggal_ujian = $_POST['tanggal_ujian'];
    $waktu_ujian = $_POST['waktu_ujian'];
    $lokasi_ujian = $_POST['lokasi_ujian'];
    $batas_waktu = $_POST['batas_waktu'];
    $deskripsi_ujian = $_POST['deskripsi_ujian'];
    $status = 'belum_mulai'; // Status default

    // Query untuk menambahkan jadwal ujian baru
    $query = "INSERT INTO jadwal_ujiann (peserta_id, jenis_ujian, tanggal_ujian, waktu_ujian, lokasi_ujian, batas_waktu, status, deskripsi_ujian)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Menyiapkan statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameter ke statement
        $stmt->bind_param("issssss", $peserta_id, $jenis_ujian, $tanggal_ujian, $waktu_ujian, $lokasi_ujian, $batas_waktu, $status, $deskripsi_ujian);
        
        // Eksekusi statement
        if ($stmt->execute()) {
            echo "Jadwal ujian berhasil ditambahkan.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Form untuk menambahkan jadwal ujian baru -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Tambah Jadwal Ujian</h2>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
            <input type="text" class="form-control" id="jenis_ujian" name="jenis_ujian" required>
        </div>
        
        <div class="mb-3">
            <label for="tanggal_ujian" class="form-label">Tanggal Ujian</label>
            <input type="date" class="form-control" id="tanggal_ujian" name="tanggal_ujian" required>
        </div>

        <div class="mb-3">
            <label for="waktu_ujian" class="form-label">Waktu Ujian</label>
            <input type="time" class="form-control" id="waktu_ujian" name="waktu_ujian" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_ujian" class="form-label">Lokasi Ujian</label>
            <input type="text" class="form-control" id="lokasi_ujian" name="lokasi_ujian">
        </div>

        <div class="mb-3">
            <label for="batas_waktu" class="form-label">Batas Waktu Ujian</label>
            <input type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu">
        </div>

        <div class="mb-3">
            <label for="deskripsi_ujian" class="form-label">Deskripsi Ujian</label>
            <textarea class="form-control" id="deskripsi_ujian" name="deskripsi_ujian" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
