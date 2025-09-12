<?php
class Siswa
{
    private $nama;
    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function perkenalan()
    {
        return "Halo, saya $this->nama.";
    }
}
