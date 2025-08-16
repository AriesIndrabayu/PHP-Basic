<?php
/*
Parsing data siswa dari CSV sederhana
tujuan: memecah data csv menjadi array, lalu menampilkannya dengan format yang rapi.

Alur:
1. Data siswa --> bentuk CSV "Andi, Budi, Dika, Citra"
2. Gunakan fungsi explode() untuk memecah menjadi array
3. Tampilkan hasil array satu persatu ke layar
*/

// Data siswa dalam format CSV
$data = "Andi, Budi, Dika, Citra";

// Pecah string jadi array berdasarkan koma
$siswa = explode(",", $data); // ["Andi", "Budi", "Dika", "Citra"]

$data_siswa = [
    ["nama" => "Oded", "usia" => 20],
    ["nama" => "Bambang", "usia" => 24],
    ["nama" => "Dudung", "usia" => 21],
    ["nama" => "Ujang", "usia" => 30],
];

// Tampilkan daftar siswa
echo "=== DAFTAR SISWA ===\n";
foreach ($siswa as $item) {
    echo "- " . trim($item) . "\n";
}

foreach ($data_siswa as $key => $value) {
    $no = $key + 1;
    echo "$no. " . trim($value["nama"]) . " usia: " . $value["usia"] . " tahun\n";
}
