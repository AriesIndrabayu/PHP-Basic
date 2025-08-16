<?php

// var_dump(true + 2);
// var_dump(false + 2);
// var_dump(true . "abcd");

// exit();

echo "Masukkan nilai pertama: ";
$input1 = trim(fgets(STDIN));


echo "Masukkan nilai kedua: ";

$a = 0;
while ($a < 1) {
    $input2 = trim(fgets(STDIN));
    if ((int) $input2 === 5) {
        $a++;
        // $a = $a + 1;
    } else {
        echo "\nMaaf yang diinputkan harus angka, silahkan input ulang: ";
    }
}




echo "\n=== TANPA CASTING ===\n";
$hasilTambah = $input1 + $input2;

$hasilKali = $input1 * $input2;

echo "Input 1 : $input1 (" . gettype($input1) . ")\n";
echo "Input 2 : $input2 (" . gettype($input2) . ")\n";
echo "Hasil Penambahan: $hasilTambah\n";
echo "Hasil Perkalian: $hasilKali\n";

echo "\n=== KONDISI BOOLEAN ===\n";


if ($input1) {
    echo "Input 1 dianggap TRUE dalam konteks boolean\n";
} else {
    echo "Input 1 dianggap FALSE dalam konteks boolean\n";
}
if ($input2) {
    echo "Input 2 dianggap TRUE dalam konteks boolean\n";
} else {
    echo "Input 2 dianggap FALSE dalam konteks boolean\n";
}
