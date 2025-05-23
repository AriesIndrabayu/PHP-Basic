<?php
// Variabel dengan berbagai tipe data
$nama = "Andi";               // String
$umur = 21;                   // Integer
$tinggi = 172.5;              // Float
$isMahasiswa = true;         // Boolean

// Tampilkan isi variabel
echo "Nama: " . $nama . "<br>";
echo "Umur: " . $umur . " tahun<br>";
echo "Tinggi badan: " . $tinggi . " cm<br>";
if ($isMahasiswa) {
    echo "Saya adalah seorang mahasiswa.";
} else {
    echo "Saya bukan mahasiswa.";
}
?>
