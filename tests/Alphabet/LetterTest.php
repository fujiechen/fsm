<?php

declare(strict_types=1);

namespace Tests\Alphabet;

use FSM\Alphabet\Letter;
use PHPUnit\Framework\TestCase;

class LetterTest extends TestCase
{
    public function testConstructor()
    {
        $res = new Letter('1');

        $this->assertInstanceOf(Letter::class, $res);
    }

    public function testGetValue()
    {
        $letter = new Letter('1');
        $res = $letter->getValue();

        $this->assertEquals('1', $res);
    }

    public function testGetCompareValue()
    {
        $letter = new Letter('1');
        $res = $letter->getCompareValue();

        $this->assertEquals('1', $res);
    }

    public function testIsEqualTrue()
    {
        $letter1 = new Letter('1');
        $letter2 = new Letter('1');
        $res = $letter1->isEqual($letter2);

        $this->assertTrue($res);
    }

    public function testIsEqualFalse()
    {
        $letter1 = new Letter('1');
        $letter2 = new Letter('2');
        $res = $letter1->isEqual($letter2);

        $this->assertFalse($res);
    }
}
