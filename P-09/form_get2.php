<!-- 
kunjungi:
https://getbootstrap.com/docs/5.3/getting-started/introduction/

-->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latihan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>
  <body>
    <?php
    // var_dump($_GET);
    if (isset($_GET["nama"]) && $_GET["nama"] !== "") {
        ?>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="card" style="width: 18rem;">
            <div class="card-header">
                Output dari Form GET dengan Bootstrap
            </div>
            <div class="card-body">
                <p>Nama: <?php echo htmlspecialchars($_GET['nama']); ?></p>
                <form action="form_get2.php" method="GET">
                    <input type="hidden" name="nama" value="">
                    <input type="submit" class="btn btn-primary" value="Kembali">
                </form>
            </div>
            </div>    
        
        
            
        </div>
        <?php
    } else {
        ?>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <!-- 
            | Class                    | Fungsi                                                                                                                             |
            | ------------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
            | `container`              | Memberikan padding horizontal secara otomatis dan mengatur lebar konten agar tidak penuh di layar besar.                           |
            |                          | Ini adalah class Bootstrap standar untuk **membungkus konten**.                                                                    |
            | `d-flex`                 | Mengaktifkan Flexbox (display: flex) untuk elemen ini. Flexbox memudahkan dalam menyusun elemen secara **horizontal atau vertikal**|
            | `justify-content-center` | Mengatur isi di tengah **secara horizontal** (center X).                                                                           |
            | `align-items-center`     | Mengatur isi di tengah **secara vertikal** (center Y).                                                                             |
            | `min-vh-100`             | Artinya `minimum vertical height = 100%`, yaitu div ini memiliki tinggi minimal **100% dari tinggi viewport (layar browser)**.     |
            |                          | Ini penting supaya konten benar-benar bisa "tengah vertikal".                                                                      |
            -->
            <div class="card">
            <div class="card-header">
                Form GET dengan Bootstrap
            </div>
            <div class="card-body">
                <form action="form_get2.php" method="GET">
                <div class="mb-3">
                    <label for="" class="form-label">Nama:</label>
                    <input type="text" class="form-control" name="nama">
                </div>
                <input type="submit" class="btn btn-success" value="Kirim">
            </form>
            </div>
            </div>   
        </div>
        
        
        <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>
