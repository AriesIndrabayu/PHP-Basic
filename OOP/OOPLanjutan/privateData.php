<?php
class BankAccount
{
    private $owner;
    private $balance;

    public function __construct($owner, $initial = 0)
    {
        $this->owner = $owner;
        $this->balance = 0;
        $this->deposit($initial);
    }

    public function deposit($amount)
    {
        if ($amount > 0) {
            $this->balance += $amount;
            // $this->balance = $this->balance + $amount;
            return true;
        }
        return false;
    }

    public function withdraw($amount)
    {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    public function getBalance()
    {
        return $this->balance;
    }
}

$acc = new BankAccount("Ocim", 1000);
$acc->deposit(500);
$acc->withdraw(200);
// $acc->balance = 100_000_000;
echo $acc->getBalance() . PHP_EOL;
