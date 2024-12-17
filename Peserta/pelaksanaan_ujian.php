<?php
session_start();
include 'db.php'; // Koneksi ke database

// Ambil ID peserta dari session
$peserta_id = $_SESSION['id'];

// Cek data peserta
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc(); 

// Pastikan nama peserta ada dalam data
if (isset($peserta['username'])) {
    $username = $peserta['username'];
} else {
    $username = "Nama peserta tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaksanaan Ujian</title>
    <!-- Menambahkan link ke Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
    background-color: #e5e5e5; /* Warna latar belakang netral */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

.navbar {
    background-color: #6c757d; /* Warna abu-abu netral untuk navbar */
}

.navbar a {
    color: white !important;
}

.navbar .navbar-brand {
    font-weight: bold;
}

.container {
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    border: 1px solid #ddd; /* Warna netral untuk border */
    background-color: transparent; /* Menghapus latar belakang putih */
}

.header-content {
    background-color: #f8f9fa; /* Warna latar belakang netral terang */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-bottom: 30px;
}

.header-content h2 {
    color: #333; /* Warna teks gelap yang netral */
}

.header-content p {
    color: #555; /* Warna teks abu-abu muda */
}

.form-select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background-color: #f8f9fa; /* Warna latar belakang dropdown yang lembut */
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #6c757d;
    box-shadow: 0 0 5px rgba(108, 117, 125, 0.5); /* Fokus dengan warna abu-abu */
}

.form-label {
    font-weight: bold;
    text-align: center;
    display: block;
}

.d-flex-center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    text-align: center;
}

    </style>
</head>
<body>

    <!-- Navbar menggunakan Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pelaksanaan Ujian Peserta</a>
        </div>
    </nav>

    <div class="container d-flex-center">
        <div class="header-content">
            <h2>Pelaksanaan Ujian Peserta</h2>
            <p>Selamat datang, <strong><?php echo $username; ?></strong></p>
            
            <!-- Form untuk memilih jenis ujian -->
            <form method="GET" action="" class="mt-4">
                <div class="mb-3">
                    <label for="jenis_ujian" class="form-label">Pilih Jenis Ujian</label>
                    <select class="form-select" name="jenis_ujian" id="jenis_ujian" onchange="this.form.submit()">
                        <option value="">Pilih Jenis Ujian</option>
                        <option value="Tertulis.php">Ujian Tertulis</option>
                        <option value="Wawancara.php">Ujian Wawancara</option>
                        <option value="Seminar.php">Seminar</option>
                        <option value="Praktik.php">Praktikum</option>
                        <option value="StudiKasus.php">Studi Kasus</option>
                        <option value="Portofolio.php">Portofolio</option>
                    </select>
                </div>
            </form>

            <?php
            // Mengalihkan ke halaman ujian berdasarkan jenis ujian yang dipilih
            if (isset($_GET['jenis_ujian']) && !empty($_GET['jenis_ujian'])) {
                $jenis_ujian = $_GET['jenis_ujian'];
                header("Location: $jenis_ujian"); // Mengalihkan ke halaman ujian yang dipilih
                exit();
            }
            ?>
        </div>
    </div>

    <!-- Menambahkan Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
