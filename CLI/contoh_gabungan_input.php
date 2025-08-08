<?php

// cek apakah argumen nama diberikan?
if (isset($argv) && count($argv) >= 2) {
    // menggunakan fitur ARGV
    $nama = $argv[1];
    echo "Halo, $nama!\n";
} else {
    // menggunakan fitur STDIN
    echo "Masukkan nama: ";
    $nama = trim(fgets(STDIN));
    echo "Halo, $nama!\n";
}
