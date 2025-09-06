<?php
/*
1. Apa itu Callback function?
- fungsi yang dipanggil melalui paramter dari fungsi lain.
- bukan kita langsung memanggil, melainkan fungsi lain memanggilkannya untuk kita.
- bentuk callback bisa berupa:
    - Anonymous function
    - Nama fungsi biasa (string)
    - Method dari class (array atau string dengan notasi khusus)
*/

// 2. Contoh dasar callback dengan array_map
$data = [1, 2, 3];
$hasil = array_map(fn($x) => $x * 2, $data);
print_r($hasil);
echo PHP_EOL;

// 3. Callback dengan fungsi biasa
function kaliDua($x)
{
    return $x * 2;
}
$data = [1, 2, 3];
$hasil = array_map("kaliDua", $data);
print_r($hasil);
echo PHP_EOL;

// 4. Callback ke Method dalam class

class Kalkulator
{
    public static function kaliTiga($x)
    {
        return $x * 2;
    }
}

$data = [1, 2, 3];
// callback ke method static

$hasil = array_map(["Kalkulator", "kaliTiga"], $data);

print_r($hasil);
echo PHP_EOL;

// 5. Callback yang dipakai di Event Handler

function jalankanEvent($event, $callback)
{
    echo "Event: $event " . PHP_EOL;
    $callback($event); // panggil fungsi callback
}

jalankanEvent("Login", function ($e) {
    echo "User berhasil $e!" . PHP_EOL;
});

// 6. Built-in function yang digunakan callback
/*
- array_map($callback, $array) -> memodifikasi setiap elemen array

- array_filter($array, $callback) -> filtering elemen array

- usort($array, $callback) -> sorting dengan aturan custom

- array_reduce($array, $callback, $initial) -> reduksi array menjadi satu nilai
*/
// contoh array_filter
$data = [1, 2, 3, 4, 5];
// ambil angka genap dari variabel data
$hasil = array_filter($data, fn($x) => $x % 2 == 0);
print_r($hasil);
echo PHP_EOL;


/*
sintaks variadic function
a. *$args
b. **$args
c. ...$args
d. $arg[]

array_sum()
*/