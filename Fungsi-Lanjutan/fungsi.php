<?php

// 1. Default Parameter di dalam fungsi
function halo($nama = "Tamu")
{
    echo "Halo, $nama!" . PHP_EOL;
}


halo();
halo("Oded");




/*
cara penulisan fungsi dengan parameter default
function contoh($a, $b = 10)
{

}
function salah($a=10, $b)
{

}

function contoh($a, $b = 10)
{
    $hasil  = $a + $b;
    echo "hasilnya: $hasil" . PHP_EOL;
}
*/


// CLI: Command Line Interface
// di linux/macOS PHP_EOL = "\n"
// windows = "\r\n"
// GUI: Graphical User Interface
// <br>

// 2. Static Variable
function counter()
{
    static $x = 0;
    $x++;
    echo "Nilai x: $x " . PHP_EOL;
}

counter();
counter();
counter();
counter();


// Gabungkan Parameter default dengan static variable

function hitungKunjungan($nama = "Tamu")
{
    static $data = [];
    if (!isset($data[$nama])) {
        $data[$nama] = 0; # ini di jalankan jika data belum ada
    }
    $data[$nama]++;

    echo "Halo, $nama! Kamu sudah berkunjung {$data[$nama]} kali." . PHP_EOL;
}

hitungKunjungan(); # 0+1 = 1
hitungKunjungan(); # 1 + 1 = 2
hitungKunjungan("Heri"); # 0 + 1 = 1
hitungKunjungan("Bayu"); # 0 + 1 = 1
hitungKunjungan(); # 2 + 1 = 3
hitungKunjungan("Heri"); # 1 + 1 = 2
hitungKunjungan("Bayu"); # 1 + 1 = 2
hitungKunjungan("Bayu"); # 2 + 1 = 3
