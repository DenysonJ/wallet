<?php

namespace App\Domain\Document;

interface DocumentValidator {
    public function isValid(string $document): bool;
}