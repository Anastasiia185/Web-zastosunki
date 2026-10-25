<?php
require_once __DIR__ . '/AccountInterface.php';

class InsufficientFundsException extends Exception
{
    public function __construct(float $needed, float $available, string $currency = 'USD')
    {
        parent::__construct(sprintf(
            "Недостатньо коштів: потрібно %s %s, доступно %s %s",
            number_format($needed, 2),
            $currency,
            number_format($available, 2),
            $currency
        ));
    }
}

class BankAccount implements AccountInterface
{
    public const MIN_BALANCE = 0;
    protected float $balance;
    protected string $currency;
    public function __construct(float $initialBalance = 0.0, string $currency = 'USD')
    {
        if ($initialBalance < self::MIN_BALANCE) {
            throw new Exception("Початковий баланс не може бути меншим за " . self::MIN_BALANCE);
        }

        $this->balance  = $initialBalance;
        $this->currency = $currency;
    }
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception("Сума поповнення має бути більшою за 0.");
        }

        $this->balance += $amount;
    }
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new Exception("Сума зняття має бути більшою за 0.");
        }

        if ($amount > $this->balance) {
            throw new InsufficientFundsException($amount, $this->balance, $this->currency);
        }

        $this->balance -= $amount;

        if ($this->balance < self::MIN_BALANCE) {
            throw new Exception("Баланс не може бути меншим за мінімально допустимий (" . self::MIN_BALANCE . ").");
        }
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }
    public function __toString(): string
    {
        return sprintf('%s %s', number_format($this->balance, 2), $this->currency);
    }
}