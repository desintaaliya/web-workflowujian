<?php
// Koneksi ke database
include 'db.php';

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data notifikasi untuk penguji yang statusnya 'Belum Dibaca'
$notifikasi_query = "SELECT n.id AS notifikasi_id, p.nama AS penguji_nama, n.pesan, n.status 
                     FROM notifikasi_penunjukan n
                     JOIN penguji p ON n.penguji_id = p.id 
                     WHERE n.status = 'Belum Dibaca'";

// Eksekusi query
$notifikasi_result = $conn->query($notifikasi_query);

// Periksa apakah query berhasil
if (!$notifikasi_result) {
    // Jika query gagal, tampilkan pesan error
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Penunjukan Penguji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Notifikasi Penunjukan Penguji</h2>

    <?php if ($notifikasi_result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Penguji</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $notifikasi_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['penguji_nama']); ?></td>
                            <td><?= htmlspecialchars($row['pesan']); ?></td>
                            <td><span class="badge bg-warning"><?= htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <form method="POST" action="konfirmasi_notifikasi.php" style="display: inline;">
                                    <input type="hidden" name="notifikasi_id" value="<?= $row['notifikasi_id']; ?>">
                                    <button type="submit" name="aksi" value="Bisa" class="btn btn-success btn-sm">Bisa</button>
                                    <button type="submit" name="aksi" value="Tidak Bisa" class="btn btn-danger btn-sm">Tidak Bisa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Tidak ada notifikasi penunjukan yang perlu dikonfirmasi.</div>
    <?php endif; ?>
</div>

<!-- Optional Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
