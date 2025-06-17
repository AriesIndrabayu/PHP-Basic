<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validasi Kosong
    if (empty($_POST['nama'])) {
      echo "Nama gak boleh kosong!";
    }
    
    // Validasi Panjang Minimum
    if (strlen($_POST['password']) < 6) {
      echo "Password minimal 6 karakter ya!";
    }
    
    // Validasi Format Email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      echo "Email-nya gak valid, bro!";
    }
    
    // Validasi Regex (Opsional)
    if (!preg_match("/^[a-zA-Z ]*$/", $_POST['nama'])) {
      echo "Nama cuma boleh huruf dan spasi!";
    }
}

?>

<form method="POST" action="latihan1.php">
  Nama: <input type="text" name="nama"><br>
  Email: <input type="text" name="email"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" value="Daftar">
</form>
