<?php

namespace App\Domain;

use \DateTimeImmutable;

class Transaction
{
    private int $id;
    private Account|CreditCard $sourceAccount;
    private int $amount;
    private DateTimeImmutable $date;
    private string $description;
    private string $category;
    private string $type;
    private bool $recurring;

    public function __construct(
        int $id,
        Account|CreditCard $sourceAccount,
        int $amount,
        DateTimeImmutable $date,
        string $description,
        string $category,
        string $type,
        bool $recurring
    ) {
        $this->id = $id;
        $this->sourceAccount = $sourceAccount;
        $this->amount = $amount;
        $this->date = $date;
        $this->description = $description;
        $this->category = $category;
        $this->type = $type;
        $this->recurring = $recurring;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSourceAccount(): Account|CreditCard
    {
        return $this->sourceAccount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isRecurring(): bool
    {
        return $this->recurring;
    }
}
