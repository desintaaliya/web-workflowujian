<?php
session_start();
include 'db.php'; // Koneksi ke database

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika jawaban dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jawaban'])) {
    $jawaban = $_POST['jawaban']; // Jawaban yang dikirim melalui form

    foreach ($jawaban as $soal_id => $jawaban_peserta) {
        // Query untuk mengambil jawaban benar dari database
        $query = "SELECT jawaban_benar FROM soal_tertulis WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $soal_id);
        $stmt->execute();
        $stmt->bind_result($jawaban_benar);
        $stmt->fetch();
        $stmt->close();

        // Bandingkan jawaban peserta dengan jawaban yang benar
        if ($jawaban_peserta == $jawaban_benar) {
            // Jawaban benar
            echo "Soal ID: $soal_id - Jawaban Anda benar!<br>";
        } else {
            // Jawaban salah
            echo "Soal ID: $soal_id - Jawaban Anda salah.<br>";
        }
    }
    echo "<br><a href='ujian_tertulis.php'>Kembali ke ujian</a>";
} else {
    echo "Tidak ada jawaban yang dikirim.";
}
?>
