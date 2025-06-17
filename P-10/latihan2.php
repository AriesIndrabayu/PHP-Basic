<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (empty($_POST['nama'])) $errors[] = "Nama wajib diisi!";
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid!";
    if (strlen($_POST['password']) < 6) $errors[] = "Password terlalu pendek!";

    if (!empty($errors)) {
    foreach ($errors as $err) {
        echo "<p>$err</p>";
    }
    }
    $nama = $_POST["nama"] ?? ""; // ?? adalah null coalescing operator di PHP (mulai dari PHP 7). Artinya: "kalau variabel di kiri tidak ada atau bernilai null, gunakan yang kanan."
    $email = $_POST["email"] ?? "";
}
?>

<form method="POST" action="latihan2.php">
  Nama: <input type="text" name="nama" value="<?=$nama?>"><br>
  Email: <input type="text" name="email" value="<?=$email?>"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" value="Daftar">
</form>