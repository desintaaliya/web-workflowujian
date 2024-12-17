<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login_peserta.php");
    exit();
}

$peserta_id = $_SESSION['id'];

// Query untuk mendapatkan soal ujian
$query = "SELECT * FROM soal WHERE jenis_ujian = 'tertulis'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $soal = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Soal ujian tidak tersedia.";
    exit();
}

// Jika jawaban disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jawaban = $_POST['jawaban'];
    $nilai = 0;

    foreach ($jawaban as $id_soal => $jawab) {
        $query = "SELECT * FROM soal WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_soal);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['jawaban_benar'] == $jawab) {
            $nilai++;
        }
    }

    // Simpan hasil ke database
    $query = "INSERT INTO hasil_ujian (peserta_id, nilai, jenis_ujian) VALUES (?, ?, 'tertulis')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $peserta_id, $nilai);
    $stmt->execute();

    echo "Ujian selesai. Nilai Anda: $nilai.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ujian Tertulis</title>
</head>
<body>
    <h1>Ujian Tertulis</h1>
    <form method="POST">
        <?php foreach ($soal as $item): ?>
            <p><?php echo htmlspecialchars($item['pertanyaan']); ?></p>
            <?php foreach (['a', 'b', 'c', 'd'] as $opsi): ?>
                <label>
                    <input type="radio" name="jawaban[<?php echo $item['id']; ?>]" value="<?php echo $opsi; ?>">
                    <?php echo htmlspecialchars($item["opsi_$opsi"]); ?>
                </label><br>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <button type="submit">Kirim Jawaban</button>
    </form>
</body>
</html>
