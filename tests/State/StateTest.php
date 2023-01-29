<?php

declare(strict_types=1);

namespace Tests\State;

use FSM\State\State;
use PHPUnit\Framework\TestCase;

class StateTest extends TestCase
{
    public function testConstructor()
    {
        $res = new State('S1');

        $this->assertInstanceOf(State::class, $res);
    }

    public function testGetName()
    {
        $state = new State('S1');
        $res = $state->getName();

        $this->assertEquals('S1', $res);
    }

    public function testGetCompareValue()
    {
        $state = new State('S1');
        $res = $state->getCompareValue();

        $this->assertEquals('S1', $res);
    }

    public function testIsEqualTrue()
    {
        $state1 = new State('S1');
        $state2 = new State('S1');
        $res = $state1->isEqual($state2);

        $this->assertTrue($res);
    }

    public function testIsEqualFalse()
    {
        $state1 = new State('S1');
        $state2 = new State('S2');
        $res = $state1->isEqual($state2);

        $this->assertFalse($res);
    }
}
