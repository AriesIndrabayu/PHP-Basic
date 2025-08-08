<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

// Ambil data user dari users.json
$users = json_decode(file_get_contents("users.json"), true);
$loggedInUser = null;

foreach ($users as $user) {
  if ($user['username'] === $_SESSION['user']) {
    $loggedInUser = $user;
    break;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Aplikasi Galeri</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
        <?php if ($loggedInUser): ?>
          <span class="navbar-text d-flex align-items-center">
            <img src="uploads/<?= htmlspecialchars($loggedInUser['foto']) ?>" width="40" height="40" class="rounded-circle me-2">
            <?= htmlspecialchars($loggedInUser['username']) ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Galeri di Dashboard -->
  <!-- Konten -->
  <div class="container mt-4">
    <h2>Selamat Datang, <?= htmlspecialchars($loggedInUser['username']) ?></h2>
    <p>Berikut adalah galeri gambar yang telah diupload:</p>

    <!-- Galeri Gambar -->
    <div class="row">
      <?php
      $galeri = json_decode(file_get_contents("upload.json"), true);
      if ($galeri) {
        foreach ($galeri as $item) {
          echo '<div class="col-md-3 mb-4">';
          echo '<div class="card h-100">';
          echo '<img src="uploads/' . $item['link'] . '" class="card-img-top">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . htmlspecialchars($item['caption']) . '</h5>';
          echo '<p class="card-text">' . htmlspecialchars($item['deskripsi']) . '</p>';
          echo '</div></div></div>';
        }
      } else {
        echo '<p>Belum ada gambar diunggah.</p>';
      }
      ?>
    </div>
  </div>
</body>
</html>
