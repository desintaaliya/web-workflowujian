<?php
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM kelas WHERE id = $id");
header("Location: dashboard_kelas.php?message=deleted");
?>
