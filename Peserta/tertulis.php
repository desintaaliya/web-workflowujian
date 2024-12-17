<?php
session_start();
require 'db.php';  // Koneksi ke database

// Ambil soal dari database
$query = "SELECT * FROM soal";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Tertulis - Permenpan RB No. 2 Tahun 2024</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FFE6A9;
        }

        .exam-header {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-top: 40px;
            color: #B17457;
        }

        .question-box {
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-text {
            font-size: 1.4rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 15px;
        }

        .form-check-label {
            font-size: 1.1rem;
        }

        .btn-custom {
            background-color: #355F2E;
            color: white;
            font-size: 1.2rem;
            padding: 12px 25px;
            border-radius: 4px;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="exam-header">Ujian Tertulis</div>

        <form method="POST" action="hasil_ujian.php">
            <?php
            // Ambil soal dari database dan tampilkan
            $result = mysqli_query($conn, $query);
            while ($soal = mysqli_fetch_assoc($result)) {
                echo "<div class='question-box'>";
                echo "<div class='question-text'>" . $soal['soal_text'] . "</div>";
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='radio' name='soal_" . $soal['id'] . "' value='a' id='a_" . $soal['id'] . "'>";
                echo "<label class='form-check-label' for='a_" . $soal['id'] . "'>" . $soal['pilihan_a'] . "</label>";
                echo "</div>";
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='radio' name='soal_" . $soal['id'] . "' value='b' id='b_" . $soal['id'] . "'>";
                echo "<label class='form-check-label' for='b_" . $soal['id'] . "'>" . $soal['pilihan_b'] . "</label>";
                echo "</div>";
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='radio' name='soal_" . $soal['id'] . "' value='c' id='c_" . $soal['id'] . "'>";
                echo "<label class='form-check-label' for='c_" . $soal['id'] . "'>" . $soal['pilihan_c'] . "</label>";
                echo "</div>";
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='radio' name='soal_" . $soal['id'] . "' value='d' id='d_" . $soal['id'] . "'>";
                echo "<label class='form-check-label' for='d_" . $soal['id'] . "'>" . $soal['pilihan_d'] . "</label>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-custom btn-lg">Kirim Jawaban</button>
            </div>
        </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
