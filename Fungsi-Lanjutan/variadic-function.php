<?php
/*
function ($a){

}
function (...$a){

}
1. Konsep dasar
- variadic function = fungsi yang bisa menerima jumlah argument tidak terbatas
- sintaknya ...$arg
- argumen yang diterima otomatis dikumpulkan dalam bentuk array
*/

// 2. contoh dasar variadic function
function jumlah(...$angka)
{
    return array_sum($angka);
}

echo jumlah(1, 2, 3, 4, 5) . PHP_EOL;

// 3. variadic funtion bisa dikombinasikan dengan parameter bisa:
function salam($ucapan, ...$nama)
{
    foreach ($nama as $n) {
        echo "$ucapan, $n!" . PHP_EOL;
    }
}

salam("Halo", "Oded", "Tuti", "Dudung");

// 4. Variadic function + Type Hinting
function JumlahInt(int ...$angka)
{
    return array_sum($angka);
}

echo PHP_EOL;
echo JumlahInt(1, 2, 3);
echo PHP_EOL;
echo JumlahInt(1, "2", 3);
echo PHP_EOL;
echo JumlahInt(1, 2.5, 3);
echo PHP_EOL;

// 5. variadic function + Argument Unpacking
function cetak(...$kata)
{
    foreach ($kata as $k) {
        echo $k . " ";
    }
}

$data = ["Belajar", "PHP", "itu", "seru"];
cetak(...$data);
// cetak("Belajar", "PHP", "itu", "seru");
