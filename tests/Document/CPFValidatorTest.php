<?php

namespace Document;

use App\Domain\Document\CPFValidator;
use PHPUnit\Framework\TestCase;

class CPFValidatorTest extends TestCase
{
    public function testValidCpf()
    {
        $this->assertTrue((new CPFValidator())->isValid('123.456.789-09'));
    }

    public function testValidCpfWithoutDots()
    {
        $this->assertTrue((new CPFValidator())->isValid('12345678909'));
    }

    public function testInvalidCpf()
    {
        $this->assertFalse((new CPFValidator())->isValid('123.456.789-11'));
    }

    public function testInvalidCpfFormat()
    {
        $this->assertFalse((new CPFValidator())->isValid('123.456.7899'));
    }
}