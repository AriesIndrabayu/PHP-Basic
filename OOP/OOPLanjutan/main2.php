<?php
require_once 'UserService.php';

$logger = new Logger();
echo $logger->log("Ini contoh aja");
$svc = new UserService($logger, "Ujang");
$svc->greet();
