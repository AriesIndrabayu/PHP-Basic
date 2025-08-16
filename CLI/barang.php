<?php

echo "List Barang\n";
for ($i = 1; $i < count($argv); $i++) {
    echo "Item ke-$i: " . $argv[$i] . "\n";
}

echo "Masukan Bahan Bangunan:\n";
$bahan_bangunan = trim(fgets(STDIN));
echo "\nNama Bahan Bangunan: $bahan_bangunan";
