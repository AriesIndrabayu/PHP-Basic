<?php
require_once 'BankAccount.php';

$acc = new BankAccount("Oded", 500);
$acc->deposit(200);
$acc->withdraw(100);

echo "Saldo akhir: " . $acc->getBalance() . PHP_EOL;
