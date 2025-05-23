<?php
// variabel boolean
$aktif=true;

// boolean digunakan dalam pengambilan keputusan
if($aktif){
    // blok if jika variabel $aktif bernilai true
    echo 'User Aktif';
}

// boolean digunakan dalam kondisi perulangan
$lanjut = true;
while($lanjut){
    echo "<br>Kondisi jika variabel 'lanjut' masih True";
    $lanjut = false;
}

// boolena juga bisa berasal dari hasil perbandingan
$umur = 18;
$bolehMasuk = $umur >= 17;
if($bolehMasuk){
    echo "<br>Silahkan masuk ke bioskop";
}else{
    echo "<br>Maaf belum cukup umur!";
}