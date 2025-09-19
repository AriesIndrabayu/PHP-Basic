<?php
class Mahasiswa
{
    public $nama;
    public $nim;

    public function __construct($nama, $nim)
    {
        $this->nama = $nama;
        $this->nim = $nim;
    }

    public function info()
    {
        return "Mahasiswa bernama $this->nama dengan NIM $this->nim.";
    }
}

$m1 = new Mahasiswa("Oded", "12345");
$m2 = new Mahasiswa("Tati", "67890");

// Menampilkan informasi
echo $m1->info() . PHP_EOL;
echo $m2->info() . PHP_EOL;
