<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

// Ambil data peserta
$stmt = $pdo->query("SELECT * FROM peserta ORDER BY created_at DESC");
$peserta = $stmt->fetchAll();

// Menangani pengiriman form jenis ujian
$selected_ujian = isset($_POST['jenis_ujian']) ? $_POST['jenis_ujian'] : '';

// Filter peserta berdasarkan jenis ujian yang dipilih
if ($selected_ujian) {
    $stmt = $pdo->prepare("SELECT * FROM peserta WHERE jenis_ujian = :jenis_ujian ORDER BY created_at DESC");
    $stmt->execute(['jenis_ujian' => $selected_ujian]);
    $peserta = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaksanaan Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-4">
        <h1 class="text-center mb-4">Pilih Jenis Ujian</h1>

        <!-- Form Pilihan Jenis Ujian -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="jenis_ujian" class="form-label">Pilih Jenis Ujian</label>
                <select class="form-select" name="jenis_ujian" id="jenis_ujian" onchange="this.form.submit()">
                    <option value="">Pilih Jenis Ujian</option>
                    <option value="Tertulis" <?= ($selected_ujian == 'Tertulis') ? 'selected' : ''; ?>>Tertulis</option>
                    <option value="Wawancara" <?= ($selected_ujian == 'Wawancara') ? 'selected' : ''; ?>>Wawancara</option>
                    <option value="Seminar" <?= ($selected_ujian == 'Seminar') ? 'selected' : ''; ?>>Seminar</option>
                    <option value="Praktikum" <?= ($selected_ujian == 'Praktikum') ? 'selected' : ''; ?>>Praktikum</option>
                    <option value="Studi Kasus" <?= ($selected_ujian == 'Studi Kasus') ? 'selected' : ''; ?>>Studi Kasus</option>
                    <option value="Portofolio" <?= ($selected_ujian == 'Portofolio') ? 'selected' : ''; ?>>Portofolio</option>
                </select>
            </div>
        </form>

        <!-- Daftar Peserta Berdasarkan Jenis Ujian -->
        <?php if (!empty($peserta)): ?>
            <?php foreach ($peserta as $p): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p['nama']); ?></h5>
                        <p class="card-text">Jenis ujian yang akan diikuti: <?= htmlspecialchars($p['jenis_ujian']); ?></p>

                        <?php if ($p['jenis_ujian'] == 'Tertulis'): ?>
                            <p class="text-muted">Soal pilihan ganda akan muncul di sini.</p>
                        <?php elseif ($p['jenis_ujian'] == 'Wawancara'): ?>
                            <p class="text-muted">Anda akan dihubungkan dengan penguji untuk wawancara.</p>
                        <?php elseif ($p['jenis_ujian'] == 'Seminar'): ?>
                            <p class="text-muted">Silakan unggah materi presentasi Anda.</p>
                        <?php elseif ($p['jenis_ujian'] == 'Praktikum'): ?>
                            <p class="text-muted">Ikuti instruksi praktikum berikut.</p>
                        <?php elseif ($p['jenis_ujian'] == 'Studi Kasus'): ?>
                            <p class="text-muted">Pilih kasus dan berikan solusi Anda.</p>
                        <?php elseif ($p['jenis_ujian'] == 'Portofolio'): ?>
                            <p class="text-muted">Unggah portofolio Anda untuk dinilai.</p>
                        <?php endif; ?>

                        <a href="mulai_ujian.php" class="btn btn-primary">Mulai Ujian</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Data peserta tidak tersedia untuk jenis ujian yang dipilih.</p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
