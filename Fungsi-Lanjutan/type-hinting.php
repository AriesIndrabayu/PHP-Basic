<?php
/*
memastikan variabel yang di pkai sesuai tipe yang diharapkan. kalo tidak sesuai, akan dilempar ke typeError
*/

// 1. contoh: 
function LuasPersegi(int $sisi): int
{
    return $sisi * $sisi;
}

echo LuasPersegi(5);

/*
2. Jenis Type Hinting yang didukung
    - Skalar(Sejak PHP 7)
        int --> bilangan bulat
        float --> desimal
        string --> teks
        bool --> true/false
    
    - Kompleks
        array   --> hanya boleh array
        object  --> hanya boleh object
        callable    --> hanya boleh fungsi/closure/callable
        iterable    --> bisa array atau object, yang bisa diiterasi
*/

// 3. return type hint --> selain parameter, return pun bisa dipaksa:

function bagi(int $a, int $b): float
{
    return $a / $b;
}

echo PHP_EOL;
echo bagi(5, 2);
