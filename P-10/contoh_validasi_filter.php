<?php
/*
1. filter_var()
struktur kode:
filter_var($value, $filter_type)
- $value: Nilai yang ingin dicek
- $filter_type: Jenis filter yang digunakan
*/ 
//1.1 Contoh Validasi Email:
$email = "user@example.com";
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email valid!";
} else {
    echo "Email tidak valid!";
}

// 1.2 Contoh Validasi URL
$url = "https://domain.com";
if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL valid!";
} else {
    echo "URL tidak valid!";
}
// Contoh lainnya:
$val = filter_var("yes", FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE); // filter boolean
var_dump($val); // true

$ip = "192.168.1.1";
if (filter_var($ip, FILTER_VALIDATE_IP)) // filter IP
{
    echo "IP valid";
}

$username = "bayu99";
if (filter_var($username, FILTER_VALIDATE_REGEXP, [
  "options" => ["regexp" => "/^[a-zA-Z0-9]{5,12}$/"]
])) // filter RegExp
{
    echo "Username valid";
}

/*
pada filter_var selain FILTER_VALIDATE_* ada FILTER_SANITIZE_*
Selain validasi, PHP juga menyediakan sanitasi, yaitu membersihkan input dari karakter tidak aman.

Perbedaan utama antara FILTER_SANITIZE_ dan FILTER_VALIDATE_ di PHP terletak pada tujuannya dan apa yang mereka lakukan terhadap data input.
| Aspek               | `FILTER_VALIDATE_`                                        | `FILTER_SANITIZE_`                                                  |
| ------------------- | --------------------------------------------------------- | ------------------------------------------------------------------- |
| **Tujuan**          | Untuk **memeriksa** apakah data input valid               | Untuk **membersihkan** atau memfilter data dari karakter tidak aman |
| **Output**          | `true`, `false`, atau `null` jika gagal (tergantung opsi) | Nilai string yang sudah dibersihkan                                 |
| **Efek pada Data**  | Tidak mengubah data, hanya mengecek valid/tidak           | Mengubah/menyesuaikan data agar aman                                |
| **Contoh Kegunaan** | Validasi email, angka, URL, boolean, IP, dsb.             | Membersihkan input dari tag HTML, karakter aneh, spasi, dll         |

FILTER_SANITIZE_
Fungsinya untuk membersihkan data dari karakter yang tidak perlu/berbahaya agar aman untuk digunakan, disimpan, atau ditampilkan.

Contoh: Hapus karakter asing dari email
*/
$email = "admin<script>@domain.com";
$cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
echo $cleanEmail; // admin@domain.com
/*
Kelebihan: Berguna saat input dari user perlu dibersihkan sebelum disimpan
Kekurangan: Tidak menjamin data valid secara format
*/
// Contoh Perbandingan Langsung
$input = "admin@@domain.com";

// Validasi
if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
    echo "Email valid!";
} else {
    echo "Email tidak valid!"; // output
}

// Sanitasi
$sanitized = filter_var($input, FILTER_SANITIZE_EMAIL);
echo $sanitized; // output: admin@domain.com

/*
Kapan Memakai yang Mana?
| Kondisi                                              | Pakai                                                 |
| ---------------------------------------------------- | ----------------------------------------------------- |
| Butuh memastikan format benar (email, angka, IP)?    | `FILTER_VALIDATE_`                                    |
| Butuh membersihkan input sebelum diproses/tampilkan? | `FILTER_SANITIZE_`                                    |
| Ingin tampilkan kembali input yang “dibersihkan”?    | `FILTER_SANITIZE_`                                    |
| Ingin validasi sebelum simpan ke database?           | Kombinasi keduanya (`SANITIZE` dulu, lalu `VALIDATE`) |

*/
// Contoh Kombinasi:
$emailInput = $_POST['email'] ?? '';

// Bersihkan dulu
$cleanEmail = filter_var($emailInput, FILTER_SANITIZE_EMAIL);

// Validasi
if (filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
    echo "Email valid dan bersih!";
} else {
    echo "Email tidak valid meski sudah disaring!";
}




/*
2. preg_match()
struktur kode:
preg_match($pattern, $input)
- $pattern: Pola regex, ditulis di antara garis miring /.../
- $input: String yang ingin diuji
*/ 
// 2.1 Contoh: Hanya Huruf dan Spasi
$nama = "John Doe";
if (preg_match("/^[a-zA-Z ]*$/", $nama)) {
    echo "Nama valid!";
} else {
    echo "Nama tidak boleh ada angka atau simbol!";
}
/*
Artinya:
^ = awal string
[a-zA-Z ] = hanya huruf besar, kecil, dan spasi
* = bisa muncul 0 atau lebih kali
$ = akhir string
*/

// 2.2 Contoh: Cek Nomor Telepon (angka saja)
$telp = "08123456789";
if (preg_match("/^[0-9]{10,13}$/", $telp)) {
    echo "Nomor valid!";
}
// ^[0-9]{10,13}$ ➜ hanya angka dengan panjang 10 sampai 13 digit

// 2.3 Contoh: Username (huruf/angka, 5–12 karakter)
$username = "bayu123";
if (preg_match("/^[a-zA-Z0-9]{5,12}$/", $username)) {
    echo "Username valid!";
}

?>