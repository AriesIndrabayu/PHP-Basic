<?php
session_start();

$namaDariGet = $_GET['nama'] ?? '';
$namaDariPost = $_POST['nama'] ?? '';
$namaDariRequest = $_REQUEST['nama'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($namaDariPost)) {
        $_SESSION['user'] = $namaDariPost;
        setcookie("nama", $namaDariPost, time() + 3600); // 1 jam
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Superglobal PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3 text-center">Login Demo Superglobal</h4>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <hr>

                        <h6 class="mt-3">Data Superglobal:</h6>
                        <ul class="list-group">
                            <li class="list-group-item">$_GET['nama']: <strong><?= htmlspecialchars($namaDariGet) ?></strong></li>
                            <li class="list-group-item">$_REQUEST['nama']: <strong><?= htmlspecialchars($namaDariRequest) ?></strong></li>
                            <li class="list-group-item">Request Method: <strong><?= $_SERVER['REQUEST_METHOD'] ?></strong></li>
                            <li class="list-group-item">User Agent: <small><?= $_SERVER['HTTP_USER_AGENT'] ?></small></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
