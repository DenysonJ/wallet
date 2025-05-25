<?php

namespace App\Domain\Document;

class CPFValidator implements DocumentValidator
{

    public function isValid(string $document): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $document);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Cálculo do primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $cpf[$i] * (10 - $i);
        }
        $firstDigit = 11 - ($sum % 11);
        $firstDigit = $firstDigit >= 10 ? 0 : $firstDigit;

        // Cálculo do segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += (int) $cpf[$i] * (11 - $i);
        }
        $secondDigit = 11 - ($sum % 11);
        $secondDigit = $secondDigit >= 10 ? 0 : $secondDigit;

        return ($cpf[9] == $firstDigit) && ($cpf[10] == $secondDigit);
    }
}