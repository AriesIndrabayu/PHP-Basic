<?php

// Kasus 1
echo "=== Data Mahasiswa ===\n";
echo "Nama\tUmur\tJurusan\n";
echo "Bayu\t20\tInformatika\n";
echo "Andi\t21\tSisterm Informasi\n";

// Kasus 2
$path = "C:\\xampp\\htdocs\\project\\naratass";
echo "\nProyek ada di: $path";

// Kasus 3
echo "\nSelamat datang di aplikasi kami! \u{1F44B} \u{1F9B0}";

echo "<br>";
echo '
<p>
Halo Apakabar
<h1>Saya sedang belajar PHP</h1>
</p>
';

$nama = ["Oded", "Dudung", "Dadan"];
var_dump($nama);
print_r($nama);
echo ($nama[1]);
print_r($nama[0] . "\n");
print_r(100);
print_r("\nBandung");

$Kota = "Jakarta,Bandung,Surabaya,Medan";
$Daerah = explode(",", $Kota);
$DataJson =  json_encode($Daerah);

echo "Nama Kota: $DataJson  \n";
var_dump($Daerah);



echo "\n ======== NAMA KOTA ============\n";
foreach ($Daerah as $key) {
    echo "* " . $key . "\n";
}

 /* print_r($Daerah); 
 
 === Menu Aplikasi ===
 1. Login
 2. Register
 3. Exit
 Pilih salahsatu menu:
 */
