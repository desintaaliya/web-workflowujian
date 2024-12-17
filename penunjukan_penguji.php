<?php 
// Koneksi ke database
include 'db.php';

// Query untuk mengambil data penguji
$penguji_query = "SELECT id, nama FROM penguji";
$penguji_result = $conn->query($penguji_query);

// Cek apakah query berhasil
if (!$penguji_result) {
    die("Query error: " . $conn->error);
}

// Proses penunjukan penguji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data form
    $kloter_id = $_POST['kloter_id'];
    $penguji_id = $_POST['penguji_id'];

    // Validasi input
    if (!empty($kloter_id) && !empty($penguji_id)) {
        // Simpan penunjukan penguji ke database
        $insert_query = "INSERT INTO penunjukan_penguji (kloter_id, penguji_id, status) VALUES (?, ?, 'Menunggu Konfirmasi')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $kloter_id, $penguji_id);

        if ($stmt->execute()) {
            // Simpan notifikasi untuk penguji ke tabel notifikasi_penunjukan
            $pesan = "Anda telah ditunjuk untuk menguji kloter ID: " . $kloter_id;
            $notifikasi_query = "INSERT INTO notifikasi_penunjukan (pesan, status, penguji_id) VALUES (?, 'Belum Dibaca', ?)";
            $stmt_notifikasi = $conn->prepare($notifikasi_query);
            $stmt_notifikasi->bind_param("si", $pesan, $penguji_id);
            $stmt_notifikasi->execute();

            // Redirect ke halaman notifikasi setelah penunjukan berhasil
            header("Location:../penguji/notifikasi_penunjukan.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Gagal menyimpan penunjukan penguji.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Harap pilih ID kloter dan penguji.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penunjukan Penguji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Penunjukan Penguji</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="kloter_id" class="form-label">ID Kloter Ujian</label>
            <input type="text" id="kloter_id" name="kloter_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="penguji_id" class="form-label">Pilih Penguji</label>
            <select id="penguji_id" name="penguji_id" class="form-select" required>
                <!-- Menampilkan opsi penguji dari database -->
                <?php
                if ($penguji_result->num_rows > 0) {
                    // Jika ada penguji, tampilkan nama penguji
                    while($row = $penguji_result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada penguji yang tersedia</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Tentukan Penguji</button>
    </form>
</div>
</body>
</html>
