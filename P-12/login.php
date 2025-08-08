<?php
session_start();

$baru_logout = isset($_GET['logout']) && $_GET['logout'] == 1;
$pesan_logout = '';
$remember_username = '';

// Cek Remember Me jika belum baru logout
if (!$baru_logout && isset($_COOKIE['remember'])) {
  $_SESSION['user'] = $_COOKIE['remember'];
  $_SESSION['timeout'] = time();
  header("Location: dashboard.php");
  exit;
}

// Isi username dari cookie jika ada
if (isset($_COOKIE['remember'])) {
  $remember_username = $_COOKIE['remember'];
}

if ($baru_logout) {
  $pesan_logout = "Kamu sudah berhasil logout.";
}

// Inisialisasi percobaan login
if (!isset($_SESSION['login_attempt'])) {
  $_SESSION['login_attempt'] = 0;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $remember = isset($_POST['remember']);

  $users = json_decode(file_get_contents('users.json'), true);
  foreach ($users as $user) {
    if ($user['username'] === $username && password_verify($password, $user['password'])) {
      $_SESSION['user'] = $username;
      $_SESSION['timeout'] = time();
      if ($remember) {
        setcookie('remember', $username, time() + 3600); // simpan cookie ==> 3600 detik atau 1 jam
      } else {
        setcookie('remember', '', time() - 3600); // hapus cookie kalau gak dicentang
      }
      header("Location: dashboard.php");
      exit;
    }
  }

  $_SESSION['login_attempt']++;
  if ($_SESSION['login_attempt'] >= 3) {
    die("Terlalu banyak percobaan login. Silakan coba lagi nanti.");
  }
  $error = "Login gagal! Percobaan ke-" . $_SESSION['login_attempt'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <form method="post" class="w-50 mx-auto">
    <h2>Login</h2>
    <?php if (!empty($pesan_logout)): ?>
      <div class="alert alert-info"><?= $pesan_logout ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input name="username" class="form-control" value="<?= htmlspecialchars($remember_username) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" name="remember" class="form-check-input">
      <label class="form-check-label">Remember Me</label>
    </div>
    <button class="btn btn-primary">Login</button>
    <a href="register.php" class="btn btn-link">Daftar akun</a>
  </form>
</div>
</body>
</html>
