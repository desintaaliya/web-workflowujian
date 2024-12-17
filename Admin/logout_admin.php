<?php
session_start();
session_unset(); // Hapus semua session
session_destroy(); // Hapus session

header('Location: login_admin.php'); // Redirect ke halaman login setelah logout
exit;
?>
