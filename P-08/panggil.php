<?php
include ("gabungan.php");
// tampilkanBilanganGenap(20);
$nilaiMahasiswa = [
    [
        "nama" => "Bayu",
        "nilai" => [
            "Matematika" => 80,
            "IPA" => 70,
            "IPS" => 60
        ]
    ],
    [
        "nama" => "Dudung",
        "nilai" => [
            "Matematika" => 65,
            "IPA" => 70,
            "IPS" => 87
        ]
    ]
    ];

for ($i=0; $i < count($nilaiMahasiswa) ; $i++) { 
    # code...
    echo "<br>";
    cekKelulusan($nilaiMahasiswa[$i]["nama"],$nilaiMahasiswa[$i]["nilai"]);
    echo "<br>";
}

