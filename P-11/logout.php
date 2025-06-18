<?php
session_start();
session_destroy();
setcookie("nama", "", time() - 3600); // Hapus cookie
header("Location: index.php");
exit;
