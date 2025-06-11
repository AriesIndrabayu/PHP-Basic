<?php
// Pengulangan menggunakan while

/*
$i=1;
while($i <= 5){
    echo $i . "<br>";
    $i++; // <-- infinite loop --> increment
    // if ($i > 2){
    //     break;
    // }
}

$nilai=10;
while ($nilai > 0) {
    echo "Nilai sekarang: $nilai<br>";
    $nilai = $nilai - 2; // decrement
}

$input = "";
while ($input != 'exit') {
    echo "Ketik sesuatu (ketik 'exit' untuk berhenti)";
    $input = trim(fgets(STDIN)); // input dari command line
}
echo "Program selesai";
*/


// pengulangan dengan do while
/*
$i = 7;
do {
    echo "Nilai i: $i <br>";
    $i++;
} while ($i <= 5);
*/
//  contoh lain
do{
    $input = readline("Masukkan angka antara 1 sampai 10");
}while($input < 1 || $input > 10);