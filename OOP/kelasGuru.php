<?php
class Guru
{
    public $nama;
    public function mengajar()
    {
        return "$this->nama sedang mengajar";
    }
}

$g = new Guru();
$g->nama = "Tuti";

echo $g->mengajar();
