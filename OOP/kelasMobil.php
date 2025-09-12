<?php
class Mobil
{
    public $merk;
    public $warna;
    public function info()
    {
        return "Mobil $this->merk berwarna $this->warna.";
    }
}

$m = new Mobil();
$m->merk = "Toyota";
$m->warna = "Putih";
echo $m->info();
