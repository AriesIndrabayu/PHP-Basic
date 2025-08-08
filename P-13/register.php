<?php
if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $foto = $_FILES['foto'];
  $namaFoto = uniqid() . '_' . $foto['name'];
  $tujuan = 'uploads/' . $namaFoto;

  // Validasi ekstensi & ukuran file
  $ext = pathinfo($namaFoto, PATHINFO_EXTENSION);
  $allowed = ['jpg', 'jpeg', 'png'];

  if (!in_array(strtolower($ext), $allowed)) {
    $error = "Hanya file JPG/PNG yang diizinkan.";
  } elseif ($foto['size'] > 2 * 1024 * 1024) {
    $error = "Ukuran file maksimal 2MB.";
  } else {
    // Simpan foto
    move_uploaded_file($foto['tmp_name'], $tujuan);

    // Simpan data user ke users.json
    $users = json_decode(file_get_contents("users.json"), true) ?? [];
    $users[] = [
      "username" => $username,
      "password" => $password,
      "foto" => $namaFoto
    ];
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

    $success = "Registrasi berhasil! Silakan login.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrasi User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Form Registrasi</h2>

  <nav class="mb-3">
    <a href="login.php" class="btn btn-outline-primary btn-sm">Login</a>
  </nav>

  <?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
  <?php if (isset($success)) echo '<div class="alert alert-success">' . $success . '</div>'; ?>

  <form method="POST" enctype="multipart/form-data" class="mb-3">
    <div class="mb-2">
      <input type="email" name="username" placeholder="Email" class="form-control" required>
    </div>
    <div class="mb-2">
      <input type="password" name="password" placeholder="Password" class="form-control" required>
    </div>
    <div class="mb-2">
      <input type="file" name="foto" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" name="register" class="btn btn-success">Register</button>
  </form>
</body>
</html>
