
<!-- Struktur Dasar Form HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan</title>
</head>
<body>
    <?php
    // var_dump($_GET);
    if (isset($_GET["nama"]) && $_GET["nama"] !== "") {
        ?>
        <h1>Output dari Form GET</h1>
        <p>Nama: <?php echo htmlspecialchars($_GET['nama']); ?></p>
        
        <!-- 
        Fungsi htmlspecialchars() di PHP digunakan untuk mengonversi karakter-karakter khusus HTML menjadi entitas HTML, 
        agar teks yang ditampilkan tidak diproses sebagai kode HTML, melainkan ditampilkan apa adanya.

        Selalu gunakan htmlspecialchars() saat:
        - Menampilkan input dari user ke dalam halaman HTML
        - Menghindari eksekusi kode berbahaya (XSS)
        - Menjaga tampilan teks tetap literal (bukan jadi tag HTML)
        -->
        <form action="form_get1.php" method="GET">
            <input type="hidden" name="nama" value="">
            <input type="submit" value="Kembali">
        </form>
        <?php
    } else {
        ?>
        <h1>Form GET</h1>
        <form action="form_get1.php" method="GET">
            <label for="">Nama:</label>
            <input type="text" name="nama">
            <input type="submit" value="Kirim">
        </form>
        <?php
    }
    ?>
</body>
</html>


