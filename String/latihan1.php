<?php
// 1. mengambil 3 huruf terakhir
$kata = "Koding Pemograman PHP";
$akhir_kata = substr($kata, -3);
$akhir_kata2 = substr($kata, strlen($kata) - 7, 3);

echo "$akhir_kata\n";
echo "$akhir_kata2\n";

// 2. filter kalimat
$komenter = "Dasar bodoh, aplikasi ini jelek sekali";
$filter = ["bodoh", "jelek"];
$komentar_bersih = str_replace($filter, "***", $komenter);
echo "\n=== Filtering Kalimat ====";
echo "\n$komentar_bersih";

$artikel = "PHP adalah bahasa pemograman populer untuk website development.";
$kata_kunci = "Python";

if (strpos($artikel, $kata_kunci) !== false) {
    echo "\nArtikel ini membahas tentang $kata_kunci";
} else {
    echo "\nArtikel ini tidak mengandung kata kunci $kata_kunci";
}
