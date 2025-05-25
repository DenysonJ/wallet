<?php

namespace Document;

use App\Domain\Document\CNPJValidator;
use PHPUnit\Framework\TestCase;

class CNPJValidatorTest extends TestCase
{
    public function testValidCpf()
    {
        $this->assertTrue((new CNPJValidator())->isValid('19.104.490/0001-02'));
    }

    public function testValidCpfWithoutDots()
    {
        $this->assertTrue((new CNPJValidator())->isValid('13857898000160'));
    }

    public function testInvalidCpf()
    {
        $this->assertFalse((new CNPJValidator())->isValid('19.104.490/0001-12'));
    }

    public function testInvalidCpfFormat()
    {
        $this->assertFalse((new CNPJValidator())->isValid('19.104.490/001-02'));
    }
}