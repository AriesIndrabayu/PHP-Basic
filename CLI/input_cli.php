<?php
echo "Masukkan nama Anda:";
$nama = trim(fgets(STDIN));
echo "Halo, $nama!\n";

// $argv dan STDIN
/*
$argv : Argument Values
php input_cli.php Bayu
array (
    input_cli.php,
    Bayu
    25
    ...
)


STDIN : Standard Input
*/