<?php
class Siswa
{
    public $nama;

    public function sapa()
    {
        return "Halo, saya " . $this->nama;
    }
}

// membuat objek dari kelas siswa
$s1 = new Siswa();
$s1->nama = "Oded";

$s2 = new Siswa();
$s2->nama = "Tati";

// Tampilkan
echo $s1->sapa() . PHP_EOL;
echo $s2->sapa() . PHP_EOL;
