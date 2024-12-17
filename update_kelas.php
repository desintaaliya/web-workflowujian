<?php
include 'db.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $jenis_kelas = $_POST['jenis_kelas'];
    $jabatan_fungsional = $_POST['jabatan_fungsional'];
    $jenjang = $_POST['jenjang'];
    $bidang = $_POST['bidang'];

    $sql = "UPDATE kelas SET jenis_kelas = ?, jabatan_fungsional = ?, jenjang = ?, bidang = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $jenis_kelas, $jabatan_fungsional, $jenjang, $bidang, $id);

    if ($stmt->execute()) {
        header("Location: dashboard_kelas.php?message=updated");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
