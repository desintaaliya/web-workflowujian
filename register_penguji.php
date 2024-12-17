<?php
session_start();

// Include file koneksi database
include '../db.php';  // Pastikan path sesuai dengan lokasi file db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($password !== $confirm_password) {
        $error_message = 'Password dan Konfirmasi Password tidak cocok';
    } else {
        // Cek apakah username atau email sudah terdaftar
        $query = "SELECT * FROM penguji WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = 'Username atau Email sudah terdaftar';
        } else {
            // Enkripsi password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan data ke database
            $insert_query = "INSERT INTO penguji (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                $success_message = 'Registrasi berhasil. Silakan login.';
            } else {
                $error_message = 'Terjadi kesalahan saat registrasi';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Penguji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Registrasi Penguji</h2>
    <?php
    if (isset($error_message)) {
        echo "<div class='alert alert-danger'>$error_message</div>";
    }
    if (isset($success_message)) {
        echo "<div class='alert alert-success'>$success_message</div>";
    }
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
    <p class="mt-3">Sudah punya akun? <a href="login_penguji.php">Login di sini</a></p>
</div>
</body>
</html>