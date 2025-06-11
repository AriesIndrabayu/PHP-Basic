<?php
// Ini Array Indeks
echo "<br>Array Indeks ===<br>";
$buah = ["Apel", "Jeruk", "Mangga"];
var_dump($buah);
echo "<br>";
// Menambahkan data di array indeks
$buah[] = "Pisang";
var_dump($buah);
echo "<br>";

// Mengubah data di array indeks
$buah[1] = "Kedongdong";
var_dump($buah);
echo "<br>";

// Hapus data di array indeks
unset($buah[2]);
var_dump($buah);
echo "<br>";


// ==================================


// Array Asosiatif
echo "<br>Array Asosiatif ===<br>";
$profil  = [
    "nama" => "Otong", 
    "usia" => 25
];
var_dump($profil);
echo "<br>";
// Menambahkan data di array asosiatif
$profil["kota"]="Surabaya";
var_dump($profil);
echo "<br>";

// Mengubah data di array asosiatif
$profil["usia"] = 30;
var_dump($profil);
echo "<br>";

// Hapus data di array asosiatif
unset($profil["nama"]);
print_r($profil);
echo "<br>";







echo "<br><br><br>";
// Bonus
$dataSiswa = [
    [
        "id" => 1,
        "nama"=> "Otong",
        "jurusan"=> "Informatika"
    ],
    [
        "id" => 2,
        "nama"=> "Udin",
        "jurusan"=> "Elektro"
    ]
];
var_dump($dataSiswa);
echo "<br>";
$dataSiswa[0]["jurusan"] = "Elektro";
var_dump($dataSiswa);
echo "<br>";
