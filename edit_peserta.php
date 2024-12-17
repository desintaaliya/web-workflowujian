<?php
// Koneksi ke database
include 'db.php';

// Cek apakah ada ID yang diberikan melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data peserta berdasarkan ID
    $query = "SELECT * FROM peserta WHERE id = $id";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Peserta tidak ditemukan!";
        exit;
    }
}

// Update data peserta jika formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $jabatan = $_POST['jabatan'];
    $instansi = $_POST['instansi'];
    $email = $_POST['email']; // Menambahkan email

    // Update data peserta ke database
    $update_query = "UPDATE peserta SET 
                     nama='$nama', nik='$nik', alamat='$alamat', kontak='$kontak', jabatan='$jabatan', instansi='$instansi', email='$email' 
                     WHERE id=$id";
    
    if ($conn->query($update_query) === TRUE) {
        echo "Data berhasil diperbarui!";
        header("Location: daftar_peserta.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">Edit Data Peserta</h2>

    <!-- Formulir Edit Peserta -->
    <form action="" method="POST">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama:</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $row['nama']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nik" class="form-label">NIK:</label>
            <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $row['nik']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea name="alamat" id="alamat" class="form-control" required><?php echo $row['alamat']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="kontak" class="form-label">Kontak:</label>
            <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo $row['kontak']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan:</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo $row['jabatan']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="instansi" class="form-label">Instansi:</label>
            <input type="text" name="instansi" id="instansi" class="form-control" value="<?php echo $row['instansi']; ?>" required>
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $row['email']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Peserta</button>
    </form>
</div>

<!-- Link Bootstrap 5 JS dan Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
