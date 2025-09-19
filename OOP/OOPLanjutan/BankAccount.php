<?php
class BankAccount
{
    private $owner;
    private $balance;

    public function __construct($owner, $initialBalance = 0)
    {
        $this->owner = $owner;
        $this->balance = 0;
        $this->deposit($initialBalance); // pakai aturan validasi
        echo "Akun milik {$this->owner} dibuat dengan saldo {$this->balance}." . PHP_EOL;
    }

    // getter
    public function getBalance()
    {
        return $this->balance;
    }

    // setter
    public function deposit($amount)
    {
        if ($amount > 0) {
            $this->balance += $amount;
        }
    }

    public function withdraw($amount)
    {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
        }
    }
}
