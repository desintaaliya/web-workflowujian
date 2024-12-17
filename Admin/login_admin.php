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
        $admin = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id']; // Simpan ID admin dalam session
            header('Location: dashboard_admin.php'); // Redirect ke dashboard
            exit;
        } else {
            $error_message = 'Password salah';
        }
    } else {
        $error_message = 'Username tidak ditemukan';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Login Admin</h2>
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
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">Belum punya akun? <a href="register_admin.php">Daftar sebagai admin</a></p>
</div>
</body>
</html>
