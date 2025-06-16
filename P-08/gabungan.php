<?php
// contoh fungsi utnuk menampilkan deret bilangan genap mulai dari 1
function tampilkanBilanganGenap($batas){
    echo "Bilangan genap dari 1 sampai $batas: <br>";
    for ($i=1; $i <= $batas ; $i++) { 
        $tambah_koma="";
        if($i < $batas){
            $tambah_koma = ", ";
        }
        
        if($i % 2 == 0){
            echo "$i" . $tambah_koma;
        }
    }
    echo "<br>";
}

// menghitung rata-rata nilai dan kelulusan
function cekKelulusan($nama, $nilai) {
    $jumlah_mapel = count($nilai);
    $total = 0;
    foreach ($nilai as $mapel => $angka) {
        $total += $angka;
    }

    // menghitung rata2
    $rata_rata = $total/$jumlah_mapel;
    if ($rata_rata >= 60) {
        $ket = "LULUS";
    }else{
        $ket = "TIDAK LULUS";
    }
    echo "Nama: $nama <br>";
    echo "Rata-rata Nilai: $rata_rata <br>";
    echo "Keterangan: $ket";
}
?>