<?php

namespace App\Domain\Document;

use App\Domain\Enums\DocumentType;

final class DocumentValidatorFactory
{
    public static function getValidator(DocumentType $type): DocumentValidator
    {
        return match ($type) {
            DocumentType::CPF   => new CPFValidator(),
            DocumentType::CNPJ  => new CNPJValidator(),
        };
    }
}