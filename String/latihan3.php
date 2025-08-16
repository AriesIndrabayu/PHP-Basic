<?php
/*
Menggaubngkan array alamat menjadi string
Tujuan: Menyusun format alamat yang konsisten
Alur:
1. Alamat user yang disimpan dalam format array: 
    ["Jl. Merdeka 10", "Jakarta Pusat", "DKI Jakarta"]
2. Gunakan implode(", ", $alamat) untuk string alamat utuh
*/

// Alamat dalam bentuk array
$alamat = ["Jl. Merdeka 10", "Jakarta Pusat", "DKI Jakarta"];

// Gabungkan elemen/item/value array dengan koma
$alamat_lengkap = implode(", ", $alamat);

echo "Alamat lengkap: " . $alamat_lengkap;
