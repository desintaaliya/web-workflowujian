<?php
// Mulai session
session_start();

// Koneksi ke database
include 'db.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID peserta dari URL
$id = $_GET['id'];

// Ambil data peserta berdasarkan ID
$query = "SELECT peserta.*, dokumen.dokumen_path FROM peserta 
          JOIN dokumen ON peserta.id = dokumen.peserta_id 
          WHERE peserta.id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Gagal mempersiapkan query SELECT: ' . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();

if (!$peserta) {
    die("Data peserta tidak ditemukan.");
}

// Proses form verifikasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status_verifikasi'];
    $alasan_penolakan = $status === 'Tidak Lolos' ? $_POST['alasan_penolakan'] : null;

    // Validasi input
    if (!in_array($status, ['Lolos', 'Tidak Lolos'])) {
        die("Status verifikasi tidak valid.");
    }

    if ($status === 'Tidak Lolos' && empty($alasan_penolakan)) {
        die("Alasan penolakan wajib diisi jika status adalah 'Tidak Lolos'.");
    }

    // Update status verifikasi peserta
    $update_query = "UPDATE peserta SET status_verifikasi = ?, alasan_penolakan = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);

    if ($stmt === false) {
        die('Gagal mempersiapkan query UPDATE: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $status, $alasan_penolakan, $id);
    if ($stmt->execute()) {
        if ($status === 'Lolos') {
            // Tentukan jadwal ujiann
            $tanggal = '2024-12-10'; // Contoh tanggal ujian
            $waktu = '09:00:00';     // Contoh waktu ujian
            $lokasi = 'Gedung Ujian A, Ruang 101'; // Contoh lokasi ujian

            // Simpan jadwal ujian ke database
            $jadwal_query = "INSERT INTO jadwal_ujiann (peserta_id, tanggal, waktu, lokasi) VALUES (?, ?, ?, ?)";
            $jadwal_stmt = $conn->prepare($jadwal_query);
            if ($jadwal_stmt === false) {
                die('Gagal mempersiapkan query INSERT: ' . $conn->error);
            }
            $jadwal_stmt->bind_param("isss", $id, $tanggal, $waktu, $lokasi);
            $jadwal_stmt->execute();

            // Tambahkan notifikasi ke session
            $_SESSION['notifikasi'] = "Peserta {$peserta['nama']} telah lolos seleksi administrasi. 
            Jadwal ujian: $tanggal, $waktu, $lokasi.";
        } else {
            $_SESSION['notifikasi'] = "Pendaftaran peserta {$peserta['nama']} tidak lolos. 
            Alasan: $alasan_penolakan.";
        }

        // Redirect ke dashboard notifikasi
        echo "<script>alert('Status berhasil diperbarui dan notifikasi telah dikirim.'); 
        window.location.href='dashboard_notifikasi.php';</script>";
    } else {
        die('Gagal memperbarui status: ' . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Verifikasi Peserta</h2>
    <p><strong>Nama:</strong> <?php echo htmlspecialchars($peserta['nama']); ?></p>
    <p><strong>NIK:</strong> <?php echo htmlspecialchars($peserta['nik']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($peserta['email']); ?></p>
    <p><strong>Dokumen:</strong> <a href="<?php echo htmlspecialchars($peserta['dokumen_path']); ?>" target="_blank">Lihat Dokumen</a></p>
    <form method="POST">
        <div class="mb-3">
            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
            <select id="status_verifikasi" name="status_verifikasi" class="form-select" required>
                <option value="Lolos">Lolos</option>
                <option value="Tidak Lolos">Tidak Lolos</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="alasan_penolakan" class="form-label">Alasan Penolakan (jika tidak lolos)</label>
            <textarea id="alasan_penolakan" name="alasan_penolakan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
</body>
</html>
