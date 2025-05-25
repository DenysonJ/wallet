<?php

namespace App\Domain\ValueObjects;

use App\Domain\Document\DocumentValidatorFactory;
use App\Domain\Enums\DocumentType;

class Document {
    private string $value;
    private DocumentType $type;

    public function __construct (string $value, DocumentType $type) {
        $validator = DocumentValidatorFactory::getValidator($type);
        if (!$validator->isValid($value)) {
            throw new \InvalidArgumentException("Invalid document");
        }
        $this->value = preg_replace('/[^0-9]/', '', $value);
        $this->type = $type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    public function getType(): DocumentType
    {
        return $this->type;
    }
}