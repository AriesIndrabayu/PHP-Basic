<?php
// $buah1 = "Apel";
// $buah2 = "Mangga";
// $buah3 = "Jeruk";

// Ini Array Indeks
$buah = ["Apel", "Jeruk", "Mangga"];

echo $buah[0];
echo "<br>";
echo $buah[1];

// Array Asosiatif
echo "<br>Array Asosiatif ===<br>";
$profil  = [
    "nama" => "Otong", 
    "usia" => 25
];
echo "<br>Nama: " . $profil["nama"];
echo "<br>Usia: " . $profil["usia"] . " Tahun";
echo "<br>=== Ini data array original ===<br>";
var_dump($profil);

$js_profile = json_encode($profil);
echo "<br>=== Contoh convert array to json ===<br>";
var_dump($js_profile);
$arr_profile = json_decode($js_profile, true);
echo "<br>=== Contoh convert json to Array ===<br>";
var_dump($arr_profile);
$obj_profile = json_decode($js_profile);
echo "<br>=== Contoh convert json to Object ===<br>";
var_dump($obj_profile);
echo "<br>" . $obj_profile->nama;

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