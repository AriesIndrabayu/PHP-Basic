<?php
session_start();
session_destroy();
// Tidak menghapus cookie 'remember' agar Remember Me tetap jalan
header("Location: login.php?logout=1");
exit;
