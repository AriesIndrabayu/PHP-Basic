<?php
// Mudul Perpustakaan
class Perpustakaan
{
    public $judul_buku;
    public $penulis;

    public function infoBuku()
    {
        return "Buku '$this->judul_buku' ditulis oleh $this->penulis.";
    }
}
