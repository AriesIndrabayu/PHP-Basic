<?php
/*
$nama = "Bayu"; // Tipe data: String
$umur = 25; // integer
$tinggi = 170.5; // float
$status_aktif = true; // boolean
*/

// minta input string
echo "Masukkan nama Anda: ";
$nama = trim(fgets(STDIN));

// Minta input integer
echo 'Masukkan usia Anda:';
$umur = (int) trim(fgets(STDIN));

// Minta input float
echo "Masukkan tinggi badan Anda (cm): ";
$tinggi = (float) trim(fgets(STDIN));

// Minta input boolean
echo "Apakah anda sudah makan? (yes/no): ";
$jawaban = trim(fgets(STDIN));
$sudahMakan = ($jawaban === "yes" || $jawaban === "y");

// Tampilkan hasil dengan tipe datanya
echo "\n=== HASIL INPUT ===\n";
var_dump($nama);
var_dump($umur);
var_dump($tinggi);
var_dump($sudahMakan);