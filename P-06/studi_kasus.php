<?php
// menampilkan daftar nama menggunakan FOR dan FOREACH

$nama = ["Andi", "Budi", "Cici"];

// Perulangan FOR
echo "menggunakan for: <br>";
for($i=0; $i < count($nama); $i++){
    echo $nama[$i] . "<br>";
}

// menggunakan foreach:
echo "menggunakan foreach: <br>";
foreach ($nama as $n) {
    echo $n . "<br>";
}

/*
Coba kalian buat program seperti ini:
1. Tampilkan daftar mata pelajaran menggunakan FOREACH.
2. Untuk setiap mata pelajaran, tampilkan 5 angka urut dari 1 sampai 5 menggunakan FOR.
3. Setelah itu, hitung mundur dari 3 ke 1 dengan WHILE.


Contoh hasil output yang diharapkan:
Matematika:
1 2 3 4 5
3 2 1

Bahasa Indonesia:
1 2 3 4 5
3 2 1

*/