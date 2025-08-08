<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

  $users = json_decode(file_get_contents('users.json'), true);
  foreach ($users as $user) {
    if ($user['username'] === $username) {
      die("Username sudah terdaftar!");
    }
  }
  $users[] = ['username' => $username, 'password' => $password];
  file_put_contents('users.json', json_encode($users));
  echo "Registrasi berhasil! <a href='login.php'>Login</a>";
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <form method="post" class="w-50 mx-auto">
    <h2>Register</h2>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input name="username" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary">Register</button>
  </form>
</div>
