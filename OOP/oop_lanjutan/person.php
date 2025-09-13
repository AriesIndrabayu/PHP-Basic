<?php
class PersonPublic
{
    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function greet()
    {
        return "Halo, saya " . $this->nama;
    }
}

$p = new PersonPublic("Oded");
echo $p->greet() . PHP_EOL;

$p->nama = "Tati";
echo $p->greet() . PHP_EOL;
