<?php
// Mulai session
session_start();

// Koneksi ke database
include 'db.php'; // Sesuaikan dengan file koneksi database Anda

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan tanggal hari ini dalam format YYYYMMDD
$tanggal_hari_ini = date("Ymd");
$id_kloter = "KL-" . $tanggal_hari_ini; // Format ID Kloter Ujian

// Mendapatkan data ujian dari form (misalnya tanggal, waktu, dan lokasi ujian)
$tanggal = $_POST['tanggal'];  // Tanggal ujian
$waktu = $_POST['waktu'];      // Waktu ujian
$lokasi = $_POST['lokasi'];    // Lokasi ujian

// Query untuk memasukkan data ke tabel kloter_ujian
$query = "INSERT INTO kloter_ujian (kloter_id, tanggal, waktu, lokasi) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $id_kloter, $tanggal, $waktu, $lokasi);
$stmt->execute();

// Menyimpan ID Kloter yang telah disimpan di database ke session untuk notifikasi
$_SESSION['notifikasi'] = "ID Kloter Ujian berhasil disimpan: " . $id_kloter;

// Redirect atau tampilkan notifikasi setelah berhasil
header("Location: notifikasi_pengelompokan.php"); // Ganti dengan halaman yang sesuai
exit;
?>
