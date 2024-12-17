<?php
// Koneksi ke database
include 'db.php';

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$notifikasi_id = $_POST['notifikasi_id'] ?? '';
$aksi = $_POST['aksi'] ?? '';

// Pastikan nilai notifikasi_id dan aksi ada
if (empty($notifikasi_id) || empty($aksi)) {
    die("Data tidak lengkap.");
}

// Query untuk mengupdate status notifikasi
$query = "UPDATE notifikasi_penunjukan SET status = ? WHERE id = ?";

// Siapkan statement
$stmt = $conn->prepare($query);

// Periksa apakah statement berhasil disiapkan
if ($stmt === false) {
    die("Query gagal disiapkan: " . $conn->error);
}

// Bind parameter
$stmt->bind_param("si", $aksi, $notifikasi_id); // "si" menunjukkan string dan integer

// Eksekusi statement
if ($stmt->execute()) {
    echo "Status notifikasi berhasil diubah.";
} else {
    echo "Gagal mengubah status notifikasi: " . $stmt->error;
}

// Tutup statement
$stmt->close();

// Tutup koneksi
$conn->close();
?>
