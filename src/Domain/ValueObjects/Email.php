<?php

namespace App\Domain\ValueObjects;

class Email
{
    private string $address;

    public function __construct(string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email address");
        }
        $this->address = $address;
    }

    public function isEqual(Email $email): bool
    {
        return $this->address === $email->address;
    }

    public function __toString(): string
    {
        return $this->address;
    }
}