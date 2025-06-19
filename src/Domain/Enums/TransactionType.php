<?php

namespace App\Domain\Enums;

enum TransactionType: string
{
    case EXPENSE = 'EXPENSE';
    case INCOME = 'INCOME';
    case TRANSFER = 'TRANSFER';
}