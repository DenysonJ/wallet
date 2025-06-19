<?php

namespace App\Domain;

class CreditCard
{
    private int $id;
    private User $holder;
    private string $brand;
    private string $number;
    private int $limite;
    private int $closingDate;
    private int $dueDate;
    private bool $active;

    public function __construct(
        int $id,
        User $holder,
        string $brand,
        string $number,
        int $limite,
        int $closingDate,
        int $dueDate,
        bool $active
    ) {
        $this->id = $id;
        $this->holder = $holder;
        $this->brand = $brand;
        $this->number = $number;
        $this->limite = $limite;
        $this->closingDate = $closingDate;
        $this->dueDate = $dueDate;
        $this->active = $active;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHolder(): User
    {
        return $this->holder;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getLimite(): int
    {
        return $this->limite;
    }

    public function getClosingDate(): int
    {
        return $this->closingDate;
    }

    public function getDueDate(): int
    {
        return $this->dueDate;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}