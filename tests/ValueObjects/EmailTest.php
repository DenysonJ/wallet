<?php

namespace App\tests;

use App\Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = new Email('email@test.com');
        $this->assertSame('email@test.com', (string)$email);
    }

    public function testInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('invalid-email');
    }

    public function testTwoEqualEmails()
    {
        $email1 = new Email('email@test.com');
        $email2 = new Email('email@test.com');
        $this->assertTrue($email1->isEqual($email2));
    }
}