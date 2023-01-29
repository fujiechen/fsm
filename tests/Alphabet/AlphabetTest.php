<?php

declare(strict_types=1);

namespace Tests\Alphabet;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use PHPUnit\Framework\TestCase;

class AlphabetTest extends TestCase
{
    public function testConstructorWithCorrectInstanceType()
    {
        $letters = [new Letter('1'), new Letter('2')];

        $res = new Alphabet($letters);

        $this->assertInstanceOf(Alphabet::class, $res);
    }

    public function testConstructorWithIncorrectInstanceType()
    {
        $letters = [new Letter('1'), '2'];

        $this->expectExceptionMessage(Exception::class);
        $this->expectExceptionMessage(Alphabet::VALIDATE_INIT_ALPHABET_EXCEPTION_MESSAGE);

        new Alphabet($letters);
    }

    public function testGetLetters()
    {
        $letters = [new Letter('1'), new Letter('2')];

        $alphabet = new Alphabet($letters);
        $res = $alphabet->getLetters();

        $this->assertIsArray($res);
        $this->assertInstanceOf(Letter::class, $res[0]);
        $this->assertEquals('1', $res[0]->getValue());
    }

    public function testContainsTrue()
    {
        $testLetter = new Letter('1');
        $letters = [new Letter('1'), new Letter('2')];

        $alphabet = new Alphabet($letters);
        $res = $alphabet->contains($testLetter);

        $this->assertTrue($res);
    }

    public function testContainsFalse()
    {
        $testLetter = new Letter('3');
        $letters = [new Letter('1'), new Letter('2')];

        $alphabet = new Alphabet($letters);
        $res = $alphabet->contains($testLetter);

        $this->assertFalse($res);
    }
}
