<?php
// Perulangan menggunakan foreach
/*
$names = ["Andi", "Budi", "Cici"];
foreach ($names as $nama) {
    echo $nama . "<br>";
}

echo 'Nama saya: $nama';
*/

// menampilkan key dan value dari array asosiatif

$nilai = [
    "Andi" => 80,
    "Budi" => 90,
    "Cici" => 75,
];
foreach ($nilai as $nama => $skor) {
    echo $nama . " mendapatkan nilai " . $skor . " <br>";
}

