<?php
session_start();
require 'db.php';

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

// Variabel default jenis wawancara
$jenis_wawancara = "offline"; // Default jenis wawancara adalah offline
$jadwal = "04 Desember 2024, 10:00 WIB";
$lokasi = "Bandung";
$link_video_conference = "https://www.zoom.com/";

// Cek apakah ada input form untuk jenis wawancara
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_wawancara = $_POST['jenis_wawancara']; // Menyimpan pilihan jenis wawancara
}

// Mengecek apakah data peserta tersedia untuk jenis wawancara yang dipilih
$peserta_id = $_SESSION['id']; // ID peserta yang login

// Perbaiki query table name jika ada kesalahan penamaan
$query = "SELECT * FROM wawancara WHERE id = ? AND jenis_wawancara = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param("is", $peserta_id, $jenis_wawancara);
$stmt->execute();
$result = $stmt->get_result();

// Jika data peserta tidak ditemukan
if ($result->num_rows == 0) {
    $pesan = "Data peserta tidak tersedia untuk jenis ujian yang dipilih.";
} else {
    $pesan = ""; // Pesan kosong jika data peserta ada
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Wawancara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 900px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .card-header {
            background-color: #000B58;
            color: #FFF4B7;
            text-align: center;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }
        .btn-primary, .btn-success, .btn-secondary {
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 30px;
            padding: 12px 25px;
            font-size: 16px;
        }
        .alert-info {
            background-color: #51829B;
            border-color: #1B3C73;
            color: #EADFB4;
        }
        .alert-info a {
            text-decoration: none;
            color: #FFF4B7;
        }
        .btn-primary {
            background-color: #9BB0C1;
        }
        .btn-success {
            background-color: #1F509A;
            border: none;
        }
        .btn-secondary {
            background-color: #4942E4;
            border: none;
        }
        .card-body {
            padding: 30px;
        }
        .footer-text {
            font-size: 14px;
            color: #FFF4B7;
            margin-top: 30px;
        }
        .btn-lg {
            margin: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Ujian Wawancara</h1>
        </div>
        <div class="card-body">
            <p class="text-center mb-4">
                Sistem akan menghubungkan Anda dengan penguji untuk ujian wawancara.
            </p>
            <div class="mb-4">
                <h5>Jadwal Wawancara:</h5>
                <p class="lead"><strong><?= htmlspecialchars($jadwal); ?></strong></p>
            </div>

            <!-- Formulir untuk Memilih Jenis Wawancara -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="jenis_wawancara" class="form-label">Pilih Jenis Wawancara:</label>
                    <select id="jenis_wawancara" name="jenis_wawancara" class="form-select">
                        <option value="online" <?= $jenis_wawancara === "online" ? "selected" : ""; ?>>Online</option>
                        <option value="offline" <?= $jenis_wawancara === "offline" ? "selected" : ""; ?>>Offline</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Pilih Jenis Wawancara</button>
            </form>

            <!-- Menampilkan pesan jika data peserta tidak ada -->
            <?php if (!empty($pesan)): ?>
                <div class="alert alert-warning text-center">
                    <p><?= htmlspecialchars($pesan); ?></p>
                </div>
            <?php endif; ?>

            <!-- Menampilkan hasil berdasarkan pilihan jenis wawancara -->
            <?php if ($jenis_wawancara === "online"): ?>
                <div class="alert alert-info text-center">
                    <p>Wawancara akan dilakukan secara <strong>online</strong> melalui video conference.</p>
                    <a href="<?= htmlspecialchars($link_video_conference); ?>" class="btn btn-primary btn-lg" target="_blank">Masuk ke Ruang Wawancara</a>
                </div>
            <?php elseif ($jenis_wawancara === "offline"): ?>
                <div class="alert alert-info text-center">
                    <p>Wawancara akan dilakukan secara <strong>offline</strong> di lokasi berikut:</p>
                    <p><strong><?= htmlspecialchars($lokasi); ?></strong></p>
                </div>
            <?php endif; ?>

            <p class="text-muted text-center mt-4">
                Pastikan Anda hadir tepat waktu sesuai jadwal yang telah ditentukan.
            </p>

            <!-- Tombol Penilaian -->
            <div class="text-center mt-5">
                <a href="penilaian_wawancara.php?id=<?= urlencode($_SESSION['id']); ?>" class="btn btn-success btn-lg">Berikan Penilaian</a>
            </div>

            <!-- Tombol Kembali ke Pelaksanaan Ujian -->
            <div class="text-center mt-3">
                <a href="pelaksanaan_ujian.php" class="btn btn-secondary btn-lg">Kembali ke Pelaksanaan Ujian</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
