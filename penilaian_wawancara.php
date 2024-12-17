<?php
session_start();

// Pastikan pengguna login
if (!isset($_SESSION['id'])) {
    header('Location: login_pelaksanaan_ujian.php');
    exit;
}

// Proses penilaian
$total_skor = null; // Variabel untuk menyimpan skor akhir
$catatan = ''; // Variabel untuk menyimpan catatan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai kompeten untuk masing-masing pertanyaan
    $pertanyaan = [];
    $total_kompeten = 0;

    // Loop untuk 10 pertanyaan
    for ($i = 1; $i <= 10; $i++) {
        // Mengambil nilai dari setiap pertanyaan
        $pertanyaan[$i] = $_POST['pertanyaan_' . $i] ?? 'belum_kompeten';  // Default ke 'belum_kompeten' jika tidak diisi
        if ($pertanyaan[$i] === 'kompeten') {
            $total_kompeten++;
        }
    }

    // Hitung total skor
    $total_skor = ($total_kompeten / 10) * 100;
    $catatan = $_POST['catatan'] ?? '';  // Ambil catatan, default jika kosong
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Wawancara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Penilaian Wawancara</h1>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <!-- Tampilkan hasil penilaian -->
            <div class="alert alert-info">
                <h4>Hasil Penilaian</h4>
                <p><strong>Total Skor:</strong> <?= number_format($total_skor, 2) ?>%</p>
                <p><strong>Catatan:</strong> <?= htmlspecialchars($catatan) ?></p>
            </div>
            <a href="wawancara.php" class="btn btn-primary">Kembali</a>
        <?php else: ?>
            <!-- Form penilaian -->
            <form method="POST">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <div class="mb-3">
                        <label for="pertanyaan_<?= $i ?>" class="form-label">Pertanyaan <?= $i ?></label>
                        <select id="pertanyaan_<?= $i ?>" name="pertanyaan_<?= $i ?>" class="form-select" required>
                            <option value="kompeten">Kompeten</option>
                            <option value="belum_kompeten">Belum Kompeten</option>
                        </select>
                    </div>
                <?php endfor; ?>
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tampilkan Hasil</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
