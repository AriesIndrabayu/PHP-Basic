<?php
/*
Aplikasi Laporan Donasi
tema: Menyusun laporan keuangan donasi bulanan
tujuan: menampilkan data donatur dengan format rapi agar mudah dibaca

alur:
1. Data donasi masuk berupa array 
    [
        ["Andi", 15000],
        ["Budi", 250000],
        ["Oded", 75000],
    ]
2. Setiap donasi diformat dengan number_format()
3. Gunakan sprintf() untuk membuat baris laporan yang rapi
4. Cetak daftar donatur dengan format tabel
*/

// simulasi data yang masuk
$donasi = [
    ["Andi", 15000],
    ["Budi", 250000],
    ["Oded", 75000],
];

echo "=== Laporan Donasi Bulanan ===\n";
foreach ($donasi as $index => $item) {
    $noUrut = $index + 1;
    list($nama, $jumlah) = $item;
    // $nama = $item[0];
    // $jumlah = $item[1];

    // Format angka pakai ribuan
    $jumlah_format = number_format($jumlah);

    // Susun baris laporan dengan sprintf()
    $baris = sprintf("Nama: %-10s | Donasi: Rp %s", $nama, $jumlah_format);
    echo $baris . "\n";
}
