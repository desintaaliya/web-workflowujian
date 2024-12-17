<?php
// Koneksi ke database
include 'db.php';

// Ambil data peserta dan dokumen
$query = "SELECT peserta.*, 
       dokumen.dokumen_path, 
       peserta.status_verifikasi, 
       peserta.alasan_penolakan, 
       jadwal_ujiann.tanggal_ujian, 
       jadwal_ujiann.waktu_ujian, 
       jadwal_ujiann.lokasi_ujian
FROM peserta
LEFT JOIN dokumen ON peserta.id = dokumen.peserta_id
LEFT JOIN jadwal_ujiann ON peserta.id = jadwal_ujiann.peserta_id;
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta Uji Kompetensi</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .table-custom th, .table-custom td {
            text-align: center;
        }
        .table-custom th {
            background-color: #f1f1f1; /* Latar belakang netral abu-abu terang */
            color: #333; /* Warna teks gelap untuk kontras */
        }
        .table-custom tbody tr:hover {
            background-color: #e2e2e2; /* Warna abu-abu lembut saat hover */
        }
        .action-btns a {
            margin: 0 5px;
        }
        .container {
            max-width: 1200px;
        }
        .page-header {
            background-color: #f5f5f5; /* Latar belakang abu-abu terang */
            padding: 30px 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .page-header h2 {
            color: #444; /* Warna teks lebih gelap agar mudah dibaca */
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #ffffff; /* Latar belakang putih agar bersih */
        }
        .card-header {
            background-color: #6c757d; /* Latar belakang abu-abu gelap */
            color: white;
        }
        .card-body {
            padding: 20px;
        }
        .btn-custom {
            border-radius: 5px;
            padding: 8px 15px;
            background-color: #6c757d; /* Tombol dengan latar belakang abu-abu gelap */
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5a6268; /* Warna lebih gelap saat hover */
        }
    </style>
</head>
<body>

<div class="container my-5">
    <!-- Header -->
    <div class="page-header">
        <h2>Daftar Peserta Uji Kompetensi</h2>
        <p>Berikut adalah daftar peserta yang terdaftar untuk uji kompetensi. Anda dapat mengelola data peserta melalui tabel berikut.</p>
    </div>

    <!-- Tombol Tambah Peserta di atas kanan -->
    <div class="mb-3 text-end">
        <a href="tambah_peserta.php" class="btn btn-custom">
            <i class="fas fa-user-plus"></i> Tambah Peserta
        </a>
    </div>
    <!-- Add button to group participants -->
    <a href="pengelompokan_peserta.php" class="btn btn-primary mb-3">Pengelompokan Peserta</a>
    <!-- Add button to assign examiners -->
    <a href="penunjukan_penguji.php" class="btn btn-warning mb-3">Penujukan Penguji</a>


    <!-- Tabel Daftar Peserta -->
    <?php if ($result->num_rows > 0): ?>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users"></i> Daftar Peserta
            </div>
            <div class="card-body">
                <table class="table table-bordered table-custom">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Jabatan</th>
                            <th>Instansi</th>
                            <th>Dokumen</th>
                            <th>Status Verifikasi</th>
                            <th>Alasan Penolakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                <td><?php echo htmlspecialchars($row['kontak']); ?></td>
                                <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                                <td><?php echo htmlspecialchars($row['instansi']); ?></td>
                                <td>
                                    <a href="<?php echo htmlspecialchars($row['dokumen_path']); ?>" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                        echo htmlspecialchars($row['status_verifikasi'] ?: 'Belum Diverifikasi'); 
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        echo htmlspecialchars($row['alasan_penolakan'] ?: '-'); 
                                    ?>
                                </td>
                                <td class="action-btns">
                                    <?php if ($row['status_verifikasi'] !== 'Lolos'): ?>
                                        <a href="verifikasii_peserta.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Verifikasi peserta ini?');">
                                            <i class="fas fa-check-circle"></i> Verifikasi
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-success">Terverifikasi</span>
                                    <?php endif; ?>
                                    <a href="edit_peserta.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete_peserta.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?');">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Tidak ada peserta yang terdaftar.
        </div>
    <?php endif; ?>
</div>


<!-- Link Bootstrap 5 JS dan Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
