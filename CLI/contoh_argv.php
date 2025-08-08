<?php

if($argv < 2){
    echo "Penggunaa: php contoh_argv.php <nama>\n";
    exit(1);
}

$nama = $argv[1];
echo "Halo, $nama!\n";