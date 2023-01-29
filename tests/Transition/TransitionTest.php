<?php

declare(strict_types=1);

namespace Tests\Transition;

use FSM\Alphabet\Letter;
use FSM\State\State;
use FSM\Transition\Transition;
use PHPUnit\Framework\TestCase;

class TransitionTest extends TestCase
{
    public function testConstructor()
    {
        $res = new Transition(
            new State('S1'),
            new Letter('1'),
            new State('S2')
        );

        $this->assertInstanceOf(Transition::class, $res);
    }

    public function testGetState()
    {
        $transition = new Transition(
            new State('S1'),
            new Letter('1'),
            new State('S2')
        );
        $res = $transition->getState();

        $this->assertInstanceOf(State::class, $res);
        $this->assertEquals('S1', $res->getName());
    }

    public function testGetInput()
    {
        $transition = new Transition(
            new State('S1'),
            new Letter('1'),
            new State('S2')
        );
        $res = $transition->getInput();

        $this->assertInstanceOf(Letter::class, $res);
        $this->assertEquals('1', $res->getValue());
    }

    public function testGetDestination()
    {
        $transition = new Transition(
            new State('S1'),
            new Letter('1'),
            new State('S2')
        );
        $res = $transition->getDestination();

        $this->assertInstanceOf(State::class, $res);
        $this->assertEquals('S2', $res->getName());
    }
}
