<?php
// $panggilan = "sayang";
// echo "Halo {$panggilan}ku";


class Account
{
    private $owner;
    private $balance;

    public function __construct($owner, $initialBalance = 0)
    {
        $this->owner = $owner;
        $this->balance = 0;
        $this->setBalance($initialBalance);
        echo "Akun milik {$this->owner} dibuat dengan saldo awal {$this->balance}." . PHP_EOL;
    }

    // --- Getter ---
    public function getOwner()
    {
        return $this->owner;
    }
    public function getBalance()
    {
        return $this->balance;
    }

    // --- Setter dengan Validasi ---

    public function setBalance($amount) // boolean : True/False
    {
        if (!is_numeric($amount)) {
            // tolak jika bukan angka
            return false;
        }

        if ($amount < 0) {
            // tolak nilai negatif
            return false;
        }

        $this->balance = $amount;
        return true;
    }

    public function deposit($amount)
    {
        if ($amount <= 0) return false;
        return $this->setBalance($this->balance + $amount);
    }

    public function withdraw($amount)
    {
        if ($amount <= 0) return false;
        if ($amount > $this->balance) return false;
        return $this->setBalance($this->balance - $amount);
    }
}

// Implementasi:

$acc = new Account("Oded", 1000);
echo "Saldo sekarang: " . $acc->getBalance() . PHP_EOL;

// percobaan ke-1 dengan angka negatif
echo "Coba set saldo -500: ";
$result = $acc->setBalance(-500) ? "Berhasil" : "Gagal (nilai negatif tidak diijinkan)";
echo $result . PHP_EOL;

echo "Saldo setelah percobaan: " . $acc->getBalance() . PHP_EOL;

// Percobaan ke-2 melakukan deposit
$acc->deposit(300);
echo "Saldo setelah deposit 300: " . $acc->getBalance() . PHP_EOL;

// Percobaan ke-3 melakukan penarikan dana
$acc->withdraw(2000);
echo "Saldo setelah penarikan 2000: " . $acc->getBalance() . PHP_EOL;

// Percobaan ke-4 melakukan penarikan dana
$acc->withdraw(500);
echo "Saldo setelah penarikan 500: " . $acc->getBalance() . PHP_EOL;
