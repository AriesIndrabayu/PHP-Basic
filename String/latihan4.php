<?php
/*
Akan membersihkan input username agar tidak gagal login hanya karena ada spasi
tujuan: mencegah error input dan memudahkan validasi login

alur:
1. user isi form login
2. username mungkin berisi spasi di depan/akhir
3. gunakan trim() pada username sebelum dicek ke database
4. cek password seperti biasa.
*/

// Simulasi input dari user
$username_input = "     bayu    ";
$password_input = "12345";

// Bersihkan userame dari spasi
// $username_input = trim($username_input);

// Data yang tersimpan di database
$db_username = "bayu";
$db_password = "12345";

// Validasi login
if ($username_input === $db_username && $password_input === $db_password) {
    # code True
    echo "Login berhasil! Selamat datang, $username_input di Aplikasi kami";
} else {
    # code Flase
    echo "Login gagal, Username atau Password salah.";
}
