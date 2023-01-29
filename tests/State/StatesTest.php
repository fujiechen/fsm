<?php

declare(strict_types=1);

namespace Tests\State;

use FSM\State\State;
use FSM\State\States;
use PHPUnit\Framework\TestCase;

class StatesTest extends TestCase
{
    public function testConstructorAndPassValidation()
    {
        $stateArr = [new State('S1'), new State('S2')];
        $res = new States($stateArr);

        $this->assertInstanceOf(States::class, $res);
    }

    public function testConstructorAndFailValidation()
    {
        $stateArr = [new State('S1'), 'S2'];

        $this->expectExceptionMessage(States::VALIDATE_INIT_STATES_EXCEPTION_MESSAGE);

        $res = new States($stateArr);
    }

    public function testGetStates()
    {
        $stateArr = [new State('S1'), new State('S2')];
        $res = new States($stateArr);

        $this->assertIsArray($res->getStates());
    }

    public function testContainsTrue()
    {
        $testState = new State('S1');
        $statesArr = [new State('S1'), new State('S2')];

        $states = new States($statesArr);
        $res = $states->contains($testState);

        $this->assertTrue($res);
    }

    public function testContainsFalse()
    {
        $testState = new State('S3');
        $statesArr = [new State('S1'), new State('S2')];

        $states = new States($statesArr);
        $res = $states->contains($testState);

        $this->assertFalse($res);
    }

    public function testWithinTrue()
    {
        $states1 = new States([new State('S1'), new State('S2'), new State('S3')]);
        $states2 = new States([new State('S1'), new State('S2')]);
        $res = $states2->within($states1);

        $this->assertTrue($res);
    }

    public function testWithinFalse()
    {
        $states1 = new States([new State('S1'), new State('S2'), new State('S3')]);
        $states2 = new States([new State('S1'), new State('S2')]);
        $res = $states1->within($states2);

        $this->assertFalse($res);
    }
}
