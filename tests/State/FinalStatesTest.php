<?php

declare(strict_types=1);

namespace Tests\State;

use FSM\State\FinalState;
use FSM\State\FinalStates;
use FSM\State\State;
use PHPUnit\Framework\TestCase;

class FinalStatesTest extends TestCase
{
    public function testConstructorAndPassValidation()
    {
        $stateArr = [new FinalState('S1', '1'), new FinalState('S2', '2')];
        $res = new FinalStates($stateArr);

        $this->assertInstanceOf(FinalStates::class, $res);
    }

    public function testConstructorAndFailValidation()
    {
        $stateArr = [new FinalState('S1', '1'), new State('S2')];

        $this->expectExceptionMessage(FinalStates::VALIDATE_INIT_FINAL_STATES_OBJECT_EXCEPTION_MESSAGE);

        $res = new FinalStates($stateArr);
    }

    public function testPushAndSuccess()
    {
        $finalStates = new FinalStates([new FinalState('S1', '1'), new FinalState('S2', '2')]);

        $finalStates->push(new FinalState('S3', '3'));

        $res = $finalStates->getStates();

        $this->assertCount(3, $res);
        $this->assertEquals('S3-3', $res[2]->getCompareValue());
    }

    public function testPushAndFail()
    {
        $finalStates = new FinalStates([new FinalState('S1', '1'), new FinalState('S2', '2')]);

        $this->expectExceptionMessage(FinalStates::VALIDATE_INIT_FINAL_STATES_OBJECT_EXCEPTION_MESSAGE);

        $finalStates->push(new State('S3'));
    }
}
