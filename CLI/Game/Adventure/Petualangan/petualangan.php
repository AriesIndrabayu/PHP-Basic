<?php
// State awal
$lokasi = "desa";
$hp = 100;
$inventory = [];

// Fungsi input
function tanya($pertanyaan) {
    echo $pertanyaan . " ";
    return strtolower(trim(fgets(STDIN)));
}

echo "=== SELAMAT DATANG DI GAME PETUALANGAN CLI ===\n";
echo "Kamu terbangun di sebuah desa misterius...\n";

while (true) {
    if ($lokasi == "desa") {
        echo "\nKamu berada di desa. Ada jalan ke [hutan] dan [gunung].\n";
        $aksi = tanya("Mau ke mana?");

        if ($aksi == "hutan") {
            $lokasi = "hutan";
        } elseif ($aksi == "gunung") {
            $lokasi = "gunung";
        } else {
            echo "Pilihan tidak dikenal!\n";
        }

    } elseif ($lokasi == "hutan") {
        echo "\n🌳 Kamu memasuki hutan lebat. Seekor serigala lapar muncul!\n";
        $aksi = tanya("Lari atau lawan?");

        if ($aksi == "lawan") {
            echo "⚔️ Kamu melawan serigala...\n";
            $hp -= 30;
            if ($hp <= 0) {
                echo "💀 Kamu mati! Game over.\n";
                break;
            } else {
                echo "Kamu menang! HP tersisa: $hp\n";
                $inventory[] = "Taring Serigala";
                $lokasi = "desa";
            }
        } elseif ($aksi == "lari") {
            echo "🏃 Kamu kembali ke desa.\n";
            $lokasi = "desa";
        } else {
            echo "Pilihan tidak dikenal!\n";
        }

    } elseif ($lokasi == "gunung") {
        echo "\n⛰️ Kamu sampai di gunung. Udara dingin menusuk.\n";
        $aksi = tanya("Mau [mendaki] atau [kembali]?");

        if ($aksi == "mendaki") {
            echo "❄️ Kamu menemukan harta karun! 🎁\n";
            $inventory[] = "Harta Karun";
            echo "Inventaris: " . implode(", ", $inventory) . "\n";
            echo "🎉 SELAMAT! Kamu menang!\n";
            break;
        } elseif ($aksi == "kembali") {
            $lokasi = "desa";
        } else {
            echo "Pilihan tidak dikenal!\n";
        }
    }
}
?>
