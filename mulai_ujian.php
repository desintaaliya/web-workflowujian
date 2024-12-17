<?php
// Cek apakah jenis_ujian ada di URL
if (isset($_GET['jenis_ujian'])) {
    $jenis_ujian = $_GET['jenis_ujian'];
} else {
    // Jika tidak ada, berikan pesan kesalahan atau redirect
    die("Jenis ujian tidak tersedia.");
}
?>
