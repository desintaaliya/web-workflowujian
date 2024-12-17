<?php
session_start();

// Cek apakah admin sudah login
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard_admin.php'); // Redirect ke dashboard jika sudah login
    exit;
}

// Include file koneksi database
include '../db.php';  // Pastikan path sesuai dengan lokasi file db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah username sudah terdaftar
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = 'Username sudah terdaftar';
    } else {
        // Insert data admin baru ke database
        $insert_query = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ss", $username, $password_hash);

        if ($stmt->execute()) {
            header('Location: login_admin.php'); // Redirect ke halaman login setelah sukses register
            exit;
        } else {
            $error_message = 'Gagal mendaftar, coba lagi nanti';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Daftar Admin</h2>
    <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
    <p class="mt-3">Sudah punya akun? <a href="login_admin.php">Login</a></p>
</div>
</body>
</html>
