<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM kelas WHERE id = $id");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-4">
        <h2 class="mb-4">Edit Kelas</h2>

        <!-- Form Edit Kelas -->
        <form action="update_kelas.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <div class="mb-3">
                <label for="jenis_kelas" class="form-label">Jenis Kelas:</label>
                <select name="jenis_kelas" id="jenis_kelas" class="form-select" required>
                    <option value="Kelas Khusus">Kelas Khusus</option>
                    <option value="Kelas Reguler">Kelas Reguler</option>
                </select>
            </div>

            <!-- Jabatan Fungsional -->
            <div class="mb-3">
                <label for="jabatan_fungsional" class="form-label">Jabatan Fungsional:</label>
                <select name="jabatan_fungsional" class="form-select" required>
                    <option value="Analis Perdagangan">Analis Perdagangan</option>
                    <option value="Negosiator Perdagangan">Negosiator Perdagangan</option>
                    <option value="Pengawas Perdagangan">Pengawas Perdagangan</option>
                    <option value="Penera">Penera</option>
                    <option value="Penguji Mutu Barang">Penguji Mutu Barang</option>
                    <option value="Pengamat Tera">Pengamat Tera</option>
                </select>
            </div>

            <!-- Jenjang untuk Analis Perdagangan -->
            <div class="mb-3" id="jenjang-container">
                <label for="jenjang" class="form-label">Jenjang Jabatan Fungsional Analis Perdagangan:</label>
                <select name="jenjang" class="form-select" required>
                    <option value="Ahli Pertama">Ahli Pertama</option>
                    <option value="Ahli Muda">Ahli Muda</option>
                    <option value="Ahli Madya">Ahli Madya</option>
                    <option value="Ahli Utama">Ahli Utama</option>
                </select>
            </div>

            <!-- Input Bidang -->
            <div class="mb-3">
                <label for="bidang" class="form-label">Bidang:</label>
                <input type="text" name="bidang" class="form-control" required>
            </div>


            <!-- Button Update -->
            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="dashboard_kelas.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Link Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
