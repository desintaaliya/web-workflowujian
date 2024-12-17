<?php
// Koneksi ke database
include 'db.php';

// Cek apakah ada ID yang diberikan melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data peserta (dokumen akan terhapus otomatis karena ON DELETE CASCADE)
    $delete_peserta = "DELETE FROM peserta WHERE id = $id";
    if ($conn->query($delete_peserta) === TRUE) {
        echo "Peserta berhasil dihapus beserta dokumen terkait.";
        header("Location: daftar_peserta.php");
        exit;
    } else {
        echo "Gagal menghapus peserta: " . $conn->error;
    }
} else {
    echo "ID peserta tidak ditemukan!";
}

// Menutup koneksi
$conn->close();
?>
