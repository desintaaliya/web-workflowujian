<?php
include 'db.php';

$result = $conn->query("SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kelas</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-4">
        <h2 class="mb-4">Dashboard Kelas</h2>

        <!-- Baris tombol untuk login dan tambah kelas -->
        <div class="d-flex justify-content-between mb-3">
    <a href="form_kelas.php" class="btn btn-primary">Tambah Kelas</a>
    <!-- Tombol Login untuk Peserta -->
    <a href="/Workflow%20ujian/Peserta/login_peserta.php" class="btn btn-secondary">Login Peserta</a>
</div>

        <!-- Tabel Kelas -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Jenis Kelas</th>
                    <th>Jabatan Fungsional</th>
                    <th>Jenjang</th>
                    <th>Bidang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['jenis_kelas'] ?></td>
                        <td><?= $row['jabatan_fungsional'] ?></td>
                        <td><?= $row['jenjang'] ?></td>
                        <td><?= $row['bidang'] ?></td>
                        <td>
                            <!-- Edit dan Hapus tombol dengan Bootstrap 5 -->
                            <a href="edit_kelas.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_kelas.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Link Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
