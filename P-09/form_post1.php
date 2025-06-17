
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
    // var_dump($_POST);
    if (isset($_POST["nama"]) && $_POST["nama"] !== "") {
        ?>
        <h1>Output dari Form POST</h1>
        <p>Nama: <?php echo htmlspecialchars($_POST['nama']); ?></p>
        
        <!-- 
        Fungsi htmlspecialchars() di PHP digunakan untuk mengonversi karakter-karakter khusus HTML menjadi entitas HTML, 
        agar teks yang ditampilkan tidak diproses sebagai kode HTML, melainkan ditampilkan apa adanya.

        Selalu gunakan htmlspecialchars() saat:
        - Menampilkan input dari user ke dalam halaman HTML
        - Menghindari eksekusi kode berbahaya (XSS)
        - Menjaga tampilan teks tetap literal (bukan jadi tag HTML)
        -->
        <form action="form_post1.php" method="POST">
            <input type="hidden" name="nama" value="">
            <input type="submit" value="Kembali">
        </form>
        <?php
    } else {
        ?>
        <h1>Form POST</h1>
        <form action="form_post1.php" method="POST">
            <label for="">Nama:</label>
            <input type="text" name="nama">
            <input type="submit" value="Kirim">
        </form>
        <?php
    }
    ?>
</body>
</html>


