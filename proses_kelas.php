<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $jenis_kelas = $_POST['jenis_kelas'];
    $jabatan_fungsional = $_POST['jabatan_fungsional'];
    $jenjang = $_POST['jenjang'];
    $bidang = $_POST['bidang'];

    $sql = "INSERT INTO kelas (jenis_kelas, jabatan_fungsional, jenjang, bidang) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $jenis_kelas, $jabatan_fungsional, $jenjang, $bidang);

    if ($stmt->execute()) {
        header("Location: dashboard_kelas.php?message=success");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
