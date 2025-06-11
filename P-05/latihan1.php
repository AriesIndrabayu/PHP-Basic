<?php
echo "<br>======= Latihan Ke-1=====<br>";
$nama = "Heri";
$nilai = 10.8;
var_dump(is_string($nilai));
$nilai = $nilai + 5;
$nama = $nama . " Bani";
echo "Nilai Sekarang: " . $nilai . "<br>";
echo "Nama Sekarang: " . $nama . "<br>";
if($nilai >= 75){
    echo "Lulus";
}else{
    echo "Tidak Lulus";
}

echo "<br>======= Latihan Ke-2=====<br>";

$usia = 16;
if($usia >= 17){
    echo "Boleh ikut pemilihan umum";
}else{
    echo "Belum boleh nyoblos";
}

echo "<br>======= Latihan Ke-3=====<br>";
$status = "Tidak lulus";
if($nilai >= 75) echo "Lulus";

echo "<br>======= Latihan Ke-4=====<br>";
$status = $nilai >= 75 ? "Lulus": "Tidak Lulus";
echo $status;