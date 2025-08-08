<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
// Timeout 10 menit
if (time() - $_SESSION['timeout'] > 600) {
  session_destroy();
  header("Location: login.php?timeout=1");
  exit;
} else {
  $_SESSION['timeout'] = time(); // refresh timeout
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <div class="alert alert-success">Halo, <?= $_SESSION['user'] ?>! Anda berhasil login.</div>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
