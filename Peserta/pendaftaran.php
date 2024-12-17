<?php
// Koneksi ke database
include 'db.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data form
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $jabatan = $_POST['jabatan'];
    $instansi = $_POST['instansi'];
    $email = $_POST['email'];  // Ambil data email

    // Proses file upload
    $dokumen = $_FILES['dokumen'];
    $dokumen_name = $dokumen['name'];
    $dokumen_tmp_name = $dokumen['tmp_name'];
    $dokumen_size = $dokumen['size'];
    $dokumen_error = $dokumen['error'];

    // Validasi file
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg'];
    $dokumen_type = mime_content_type($dokumen_tmp_name);

    if (!in_array($dokumen_type, $allowed_types)) {
        die("Jenis file tidak diperbolehkan. Hanya file PDF atau JPG yang diizinkan.");
    }

    // Membuat nama file unik
    $dokumen_unique_name = uniqid() . '.' . pathinfo($dokumen_name, PATHINFO_EXTENSION);

    // Tentukan lokasi folder untuk menyimpan dokumen
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Membuat folder uploads jika belum ada
    }

    // Pindahkan file ke folder uploads
    $dokumen_path = $upload_dir . $dokumen_unique_name;
    if (move_uploaded_file($dokumen_tmp_name, $dokumen_path)) {
        // Insert data peserta ke database
        $query = "INSERT INTO peserta (nama, nik, alamat, kontak, jabatan, instansi, email) 
                  VALUES ('$nama', '$nik', '$alamat', '$kontak', '$jabatan', '$instansi', '$email')";
        if ($conn->query($query) === TRUE) {
            $peserta_id = $conn->insert_id; // Mendapatkan ID peserta yang baru saja ditambahkan

            // Insert data dokumen ke database
            $query_dokumen = "INSERT INTO dokumen (peserta_id, dokumen_path, tipe_dokumen) 
                              VALUES ('$peserta_id', '$dokumen_path', '$dokumen_type')";
            if ($conn->query($query_dokumen) === TRUE) {
                // Redirect ke daftar_peserta.php setelah berhasil
                header('Location: daftar_peserta.php');
                exit; // Pastikan untuk menghentikan eksekusi lebih lanjut
            } else {
                echo "Gagal mengunggah dokumen ke database.";
            }
        } else {
            echo "Gagal menyimpan data peserta.";
        }
    } else {
        echo "Gagal mengunggah dokumen.";
    }

    // Menutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Uji Kompetensi</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-5">
        <h2 class="mb-4">Pendaftaran Uji Kompetensi</h2>

        <!-- Formulir Pendaftaran -->
        <form action="submit_pendaftaran.php" method="POST" enctype="multipart/form-data">

            <!-- Data Pribadi -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label">NIK:</label>
                <input type="text" name="nik" id="nik" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea name="alamat" id="alamat" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak:</label>
                <input type="text" name="kontak" id="kontak" class="form-control" required>
            </div>

            <!-- Data Pekerjaan -->
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan:</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi:</label>
                <input type="text" name="instansi" id="instansi" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Dokumen Persyaratan -->
            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen Persyaratan (PDF/JPG):</label>
                <input type="file" name="dokumen" id="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg" required>
            </div>

            <!-- Tombol Kirim Pendaftaran -->
            <button type="submit" name="submit" class="btn btn-primary">Kirim Pendaftaran</button>
        </form>
    </div>

    <!-- Link Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
