<?php

namespace App\Domain;

use \DateTimeImmutable;
use DateTimeZone;

class Account
{
    private int $id;
    private int $amount;
    private string $currency;
    private string $type;
    private string $description;
    private int $userId;
    private int $bankId;
    private string $agency;
    private string $account;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        int $amount,
        string $currency,
        string $type,
        string $description,
        int $userId,
        int $bankId,
        string $agency,
        string $account,
    ){
        $this->id = $id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->type = $type;
        $this->description = $description;
        $this->userId = $userId;
        $this->bankId = $bankId;
        $this->agency = $agency;
        $this->account = $account;
        $this->createdAt = new DateTimeImmutable("now", DateTimeZone::UTC);
        $this->updatedAt = new DateTimeImmutable("now", DateTimeZone::UTC);
    }
}