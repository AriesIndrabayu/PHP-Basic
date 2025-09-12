<?php
class Mahasiswa
{
    public $nama;
    public function perkenalan()
    {
        return "Halo, saya mahasiswa bernama $this->nama.";
    }
}


$mhs = new Mahasiswa();
$mhs->nama = "Ujang";
echo $mhs->perkenalan();
