<?php
// Tangkap data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hasil Input</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Data yang Anda Masukkan</h2>
  <ul class="list-group">
    <li class="list-group-item"><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></li>
    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($email) ?></li>
    <li class="list-group-item"><strong>Pesan:</strong> <?= nl2br(htmlspecialchars($pesan)) ?></li>
  </ul>
</body>
</html>
