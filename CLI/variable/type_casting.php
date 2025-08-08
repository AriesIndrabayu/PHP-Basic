<?php
echo "Masukkan angka (bisa desimal atau teks angka): ";
$input = trim(fgets(STDIN));

// Casting manual
$asString = (string) $input;
$asInteger = (int) $input;
$asFloat = (float) $input;
$asBoolean = (bool) $input;

// Tampilkan hasilnya
echo "\n=== HASIL CASTING ===\n";
echo "Asli          : $input (" . gettype($input) . ")\n";
echo "String        : $asString (" . gettype($asString) . ")\n";
echo "Integer       : $asInteger (" . gettype($asInteger) . ")\n";
echo "Float         : $asFloat (" . gettype($asFloat) . ")\n";
echo "Boolean       : $asBoolean (" . gettype($asBoolean) . ")\n";