<?php
// import class dari modul perpustakaan.php
require_once "Perpustakaan.php";

// Buat objek pertama
$b1 =  new Perpustakaan();
$b1->judul_buku = "Belajar PHP OOP";
$b1->penulis = "Ocah";

// Buat objek yang kedua
$b2 = new Perpustakaan();
$b2->judul_buku = "Dasar-dasar Web";
$b2->penulis = "Udung";

// Tampilkan hasilnya
echo $b1->infoBuku() . PHP_EOL;
echo $b2->infoBuku() . PHP_EOL;
