<?php
// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tentukan folder untuk menyimpan file yang diunggah
    $target_dir = "uploads/";  // Pastikan folder ini sudah ada
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file yang diunggah adalah gambar atau bukan
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "pdf") {
        echo "Hanya file gambar (JPG, JPEG, PNG) dan PDF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek ukuran file (misalnya max 5MB)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "File terlalu besar. Maksimal ukuran file adalah 5MB.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk = 0, artinya ada masalah dalam proses upload
    if ($uploadOk == 0) {
        echo "Gagal mengunggah file.";
    } else {
        // Mencoba untuk mengunggah file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " telah berhasil diunggah.";
        } else {
            echo "Gagal mengunggah file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Dokumen</title>
    <!-- Link Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4">Unggah Dokumen Persyaratan</h2>

        <!-- Formulir Upload -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Pilih Dokumen (PDF/JPG/JPEG/PNG)</label>
                <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Dokumen</button>
        </form>
    </div>

    <!-- Link Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
