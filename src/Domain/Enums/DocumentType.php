<?php

namespace App\Domain\Enums;

enum DocumentType: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';
}
