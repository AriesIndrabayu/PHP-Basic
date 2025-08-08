<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Galeri Gambar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Upload Galeri Gambar</h2>

  <nav class="mb-3">
    <a href="dashboard.php" class="btn btn-outline-primary btn-sm">Dashboard</a>
    <a href="galeri.php" class="btn btn-outline-success btn-sm">Galeri</a>
    <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
  </nav>

  <!-- Form Upload -->
  <form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-2">
      <input type="file" name="gambar" accept="image/*" class="form-control" required>
    </div>
    <div class="mb-2">
      <input type="text" name="caption" placeholder="Caption" class="form-control" required>
    </div>
    <div class="mb-2">
      <textarea name="deskripsi" placeholder="Deskripsi gambar" class="form-control" required></textarea>
    </div>
    <button type="submit" name="upload" class="btn btn-primary">Upload</button>
  </form>

<?php
if (isset($_POST['upload'])) {
  $gambar = $_FILES['gambar'];
  $caption = $_POST['caption'];
  $deskripsi = $_POST['deskripsi'];

  $namaFile = uniqid() . '_' . $gambar['name'];
  $tujuan = 'uploads/' . $namaFile;

  $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
  $allowed = ['jpg', 'jpeg', 'png', 'PNG'];
  if (!in_array($ext, $allowed)) {
    echo '<div class="alert alert-danger">Tipe file tidak diizinkan!</div>';
  } elseif ($gambar['size'] > 2 * 1024 * 1024) {
    echo '<div class="alert alert-danger">Ukuran file maksimal 2MB!</div>';
  } else {
    move_uploaded_file($gambar['tmp_name'], $tujuan);
    $data = json_decode(file_get_contents("upload.json"), true) ?? [];
    $data[] = ["link" => $namaFile, "caption" => $caption, "deskripsi" => $deskripsi];
    file_put_contents("upload.json", json_encode($data, JSON_PRETTY_PRINT));

    echo '<div class="alert alert-success mt-3">Gambar berhasil diupload!</div>';
    echo '<div class="mt-3"><strong>Preview:</strong><br>';
    echo '<img src="uploads/' . $namaFile . '" class="img-thumbnail" style="max-width:300px;"></div>';
  }
}

// Proses hapus gambar
if (isset($_POST['hapus'])) {
  $index = $_POST['hapus_index'];
  $data = json_decode(file_get_contents("upload.json"), true);
  if (isset($data[$index])) {
    $file = 'uploads/' . $data[$index]['link'];
    if (file_exists($file)) unlink($file);
    array_splice($data, $index, 1);
    file_put_contents("upload.json", json_encode($data, JSON_PRETTY_PRINT));
    header("Location: galeri.php");
    exit;
  }
}

// Proses edit caption/deskripsi
if (isset($_POST['edit'])) {
  $index = $_POST['edit_index'];
  $newCaption = $_POST['new_caption'];
  $newDeskripsi = $_POST['new_deskripsi'];
  $data = json_decode(file_get_contents("upload.json"), true);
  if (isset($data[$index])) {
    $data[$index]['caption'] = $newCaption;
    $data[$index]['deskripsi'] = $newDeskripsi;
    file_put_contents("upload.json", json_encode($data, JSON_PRETTY_PRINT));
    header("Location: galeri.php");
    exit;
  }
}
?>

<!-- Pencarian Galeri -->
<form method="GET" class="mb-4">
  <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan caption atau deskripsi..." value="<?php echo $_GET['search'] ?? '' ?>">
</form>

<!-- Galeri Gambar -->
<div class="row">
<?php
$data = json_decode(file_get_contents("upload.json"), true);
$keyword = strtolower($_GET['search'] ?? '');

if ($data) {
  foreach ($data as $index => $item) {
    if ($keyword) {
      if (
        strpos(strtolower($item['caption']), $keyword) === false &&
        strpos(strtolower($item['deskripsi']), $keyword) === false
      ) continue;
    }

    echo '<div class="col-md-3 mb-4">';
    echo '<div class="card h-100">';
    echo '<img src="uploads/' . $item['link'] . '" class="card-img-top">';
    echo '<div class="card-body">';
    echo '<form method="POST">';
    echo '<input type="hidden" name="edit_index" value="' . $index . '">';
    echo '<input type="text" name="new_caption" class="form-control mb-1" value="' . htmlspecialchars($item['caption']) . '" required>';
    echo '<textarea name="new_deskripsi" class="form-control mb-2" required>' . htmlspecialchars($item['deskripsi']) . '</textarea>';
    echo '<div class="btn-group" role="group">';
    echo '<button type="submit" name="edit" class="btn btn-warning btn-sm">Edit</button>';
    echo '</form>';
    echo '<form method="POST">';
    echo '<input type="hidden" name="hapus_index" value="' . $index . '">';
    echo '<button type="submit" name="hapus" class="btn btn-danger btn-sm rounded-0 rounded-end">Hapus</button>';
    echo '</form>';
    echo '</div>'; // end btn-group
    echo '</div>'; // end card-body
    echo '</div>'; // end card
    echo '</div>'; // end col
  }
} else {
  echo '<p>Belum ada gambar diupload.</p>';
}
?>
</div>
</body>
</html>
