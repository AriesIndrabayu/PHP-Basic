<?php
class Student
{
    private $name;
    private $grade;

    public function __construct($name, $grade)
    {
        $this->name = $name;
        $this->setGrade($grade);
    }

    // getter --> menampilkan data/properti/atribut
    public function getName()
    {
        return $this->name;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    // setter --> mengolah data/properti/atribut
    public function setGrade($grade)
    {
        if ($grade >= 0 && $grade <= 100) {
            $this->grade = $grade;
        }
    }
}

$s = new Student("Teti", 90);
echo $s->getName() . " nilainya: " . $s->getGrade();
