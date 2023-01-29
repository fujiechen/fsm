<?php

declare(strict_types=1);

namespace Tests\State;

use FSM\State\FinalState;
use FSM\State\State;
use PHPUnit\Framework\TestCase;

class FinalStateTest extends TestCase
{
    public function testConstructorAndExtend()
    {
        $res = new FinalState('S1', '1');

        $this->assertInstanceOf(State::class, $res);
        $this->assertInstanceOf(FinalState::class, $res);
    }

    public function testGetFinalOutput()
    {
        $finalState = new FinalState('S1', '1');
        $res = $finalState->getFinalOutput();

        $this->assertEquals('1', $res);
    }

    public function testGetName()
    {
        $finalState = new FinalState('S1', '1');
        $res = $finalState->getName();

        $this->assertEquals('S1', $res);
    }

    public function testGetCompareValue()
    {
        $finalState = new FinalState('S1', '1');
        $res = $finalState->getCompareValue();

        $this->assertEquals('S1-1', $res);
    }

    public function testIsEqualTrue()
    {
        $finalState1 = new FinalState('S1', '1');
        $finalStat2 = new FinalState('S1', '1');
        $res = $finalState1->isEqual($finalStat2);

        $this->assertTrue($res);
    }

    public function testIsEqualFalse()
    {
        $finalState1 = new FinalState('S1', '1');
        $finalStat2 = new FinalState('S1', '2');
        $res = $finalState1->isEqual($finalStat2);

        $this->assertFalse($res);
    }
}
