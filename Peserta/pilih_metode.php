<?php
session_start();

// Periksa apakah peserta sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Mendapatkan pilihan metode ujian dari form
    $metode_ujian = $_POST['metode_ujian'];

    // Simpan pilihan metode ujian ke database atau sesi
    // Contoh simpan ke sesi
    $_SESSION['metode_ujian'] = $metode_ujian;

    // Redirect ke halaman konfirmasi atau ke ujian
    header("Location: konfirmasi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Pilih Metode Ujian</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="metode_ujian" class="form-label">Pilih Metode Ujian:</label>
                <select name="metode_ujian" id="metode_ujian" class="form-select" required>
                    <option value="Ujian Tertulis (CAT)">Ujian Tertulis (CAT)</option>
                    <option value="Wawancara">Wawancara</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Praktik">Praktik</option>
                    <option value="Studi Kasus">Studi Kasus</option>
                    <option value="Portofolio">Portofolio</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Pilih Metode</button>
        </form>
    </div>
</body>
</html>
