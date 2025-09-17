<?php

class PersonProtected
{
    protected $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    protected function getNama()
    {
        return $this->nama;
    }
}

class Employee extends PersonProtected
{
    public function introduce()
    {
        return "Saya karyawan bernama: " . $this->getNama();
    }
}

$e = new Employee("Udung");
echo $e->introduce() . PHP_EOL;

// $e->nama = "Oded";
// echo $e->getNama();
