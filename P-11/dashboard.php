<?php
session_start();

$namaSession = $_SESSION['user'] ?? 'Guest';
$namaCookie = $_COOKIE['nama'] ?? 'Tidak ada';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="container py-5">
        <div class="card shadow rounded-4">
            <div class="card-body">
                <h4 class="text-success mb-3">Selamat Datang, <?= htmlspecialchars($namaSession) ?>! 👋</h4>

                <ul class="list-group mb-3">
                    <li class="list-group-item">Session: <strong><?= htmlspecialchars($namaSession) ?></strong></li>
                    <li class="list-group-item">Cookie: <strong><?= htmlspecialchars($namaCookie) ?></strong></li>
                    <li class="list-group-item">Server Name: <?= $_SERVER['SERVER_NAME'] ?></li>
                    <li class="list-group-item">IP Anda: <?= $_SERVER['REMOTE_ADDR'] ?></li>
                </ul>

                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
