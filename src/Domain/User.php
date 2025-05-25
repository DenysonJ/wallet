<?php

namespace App\Domain;

use App\Domain\Enums\DocumentType;
use \DateTimeImmutable;
use \DateTimeZone;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Document;
use App\Domain\Account;

class User
{
    private int $id;
    private string $name;
    private Email $email;
    private string $password;
    private Document $document;
    private string $language;
    private string $timezone;

    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    /* @var Account[] */
    private array $accounts;

    public function create(
        int $id,
        string $name,
        string $email,
        string $password,
        string $document,
        DocumentType $documentType,
        string $language,
        string $timezone
    ): self
    {
        return new self(
            $id,
            $name,
            new Email($email),
            $password,
            new Document($document, $documentType),
            $language,
            $timezone,
            new DateTimeImmutable("now", DateTimeZone::UTC),
            new DateTimeImmutable("now", DateTimeZone::UTC)
        );
    }

    public function __construct(
        int $id,
        string $name,
        Email $email,
        string $password,
        Document $document,
        string $language,
        string $timezone,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => getenv('PASSWORD_COST')]);
        $this->document = $document;
        $this->language = $language;
        $this->timezone = $timezone;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function document(): string
    {
        return $this->document->getValue();
    }

    public function language(): string
    {
        return $this->language;
    }

    public function timezone(): string
    {
        return $this->timezone;
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function addAccount(Account $account): void
    {
        $this->accounts[] = $account;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }
}