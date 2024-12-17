<?php
session_start();
require 'db.php';

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

// Ambil daftar kasus dari database
$sql = "SELECT * FROM kasus ORDER BY id ASC";
$result = $conn->query($sql);

// Periksa apakah query berhasil
if ($result === false) {
    // Tangani error jika query gagal
    die('Query gagal dijalankan: ' . $conn->error);
}

// Ambil hasil query jika berhasil
$kasus = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Studi Kasus</title>
    <!-- Sertakan Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Ujian Studi Kasus</h1>
        <p class="text-center mb-4">Pilih kasus dari daftar berikut dan berikan solusi Anda:</p>

        <form method="POST" action="submit_studi_kasus.php">
            <!-- Daftar Kasus -->
            <div class="mb-3">
                <?php foreach ($kasus as $k): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kasus_id" value="<?= $k['id']; ?>" id="kasus<?= $k['id']; ?>" required>
                        <label class="form-check-label" for="kasus<?= $k['id']; ?>">
                            <?= htmlspecialchars($k['judul']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Input Solusi -->
            <div class="mb-3">
                <label for="solusi" class="form-label">Solusi Anda:</label>
                <textarea name="solusi" id="solusi" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Tombol Kirim -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Kirim Solusi</button>
            </div>
        </form>
    </div>

    <!-- Sertakan Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
