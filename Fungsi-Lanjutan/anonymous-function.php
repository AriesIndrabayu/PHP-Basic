<?php
// Anonymous function (Closure)
// 1. Contoh
$kali = function ($x) {
    return $x * 2;
};

echo $kali(4);


// 2. Anonynmous function sebagai callback

$angka = [1, 2, 3, 4, 5];
$hasil = array_map(function ($n) {
    return $n * $n;
}, $angka);

print_r($hasil);

// 3. Anonymous function di PHP bisa membawa variabel dari luar scope dengan keyword use

$factor = 10;
$kali = function ($x) use ($factor) {
    $factor++;
    return $x * $factor;
};

echo $kali(5);
echo PHP_EOL;
echo $factor;

// 3a. Kalo mau reference, pakai &
echo PHP_EOL;
$counter = 1;
$increment = function () use (&$counter) {
    $counter++;
};
echo $counter;
echo PHP_EOL;
$increment();
echo $counter;
echo PHP_EOL;
$increment();
echo $counter;
echo PHP_EOL;

// 4. Immediate Execution (Dipanggil Sekali Jalan)
echo (function ($a, $b) {
    return $a + $b;
})(3, 4);

// 5. Hubungan dangan Callback Function
// - callback function = fungsi yang dikirim sebagai argumen ke fungsi lain.
// - Anonymous function = salah satu cara membuat callback (paling praktis)

// Contoh: Pakai fungsi biasa
function kuadrat($x)
{
    return $x * $x;
}
$angka = [1, 2, 3, 4];
$hasil = array_map('kuadrat', $angka);
echo PHP_EOL;
print_r($hasil);

// Contoh: Pakai Anonymous Function
$angka1 = [1, 2, 3, 4];
$hasil1 = array_map(function ($x) {
    return $x * $x;
}, $angka1);
echo PHP_EOL;
print_r($hasil);

// 6. Advanced: Closure Class
$fn = function ($x) {
    return $x * 2;
};
var_dump($fn instanceof Closure);
