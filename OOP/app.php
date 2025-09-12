<?php
require 'math_utils.php'; // memanggil modul
require 'siswa.php'; // memanggil modul

$math = new MathUtils();
echo "Hasil 5 + 3 = " . $math->tambah(5, 3) . PHP_EOL;
echo "Hasil 5 x 3 = " . $math->kali(5, 3) . PHP_EOL;

$s1 = new Siswa("Oded");
$s2 = new Siswa("Tati");

echo $s1->perkenalan() . PHP_EOL;
echo $s2->perkenalan() . PHP_EOL;
