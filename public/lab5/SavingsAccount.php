<?php
require_once __DIR__ . '/BankAccount.php';

class SavingsAccount extends BankAccount
{
    public static float $interestRate = 0.05;
    public function applyInterest(): float
    {
        if (self::$interestRate <= 0) {
            throw new Exception("Відсоткова ставка має бути більшою за 0.");
        }

        $interest = $this->balance * self::$interestRate;
        $this->balance += $interest;

        return $interest;
    }
    public static function setInterestRate(float $rate): void
    {
        if ($rate <= 0) {
            throw new Exception("Ставка має бути додатною.");
        }

        self::$interestRate = $rate;
    }
}