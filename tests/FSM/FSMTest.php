<?php

declare(strict_types=1);

namespace Tests;

use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use FSM\FSM\FSM;
use FSM\FSM\FSMArrayBuilder;
use FSM\State\FinalState;
use FSM\State\FinalStates;
use FSM\State\State;
use FSM\State\States;
use FSM\Transition\Transition;
use FSM\Transition\Transitions;
use PHPUnit\Framework\TestCase;

class FSMTest extends TestCase
{
    private FSM $fsm;

    public function setUp(): void
    {
        parent::setUp();

        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S1'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setTransitions([new Transition(new State('S2'), new Letter('2'), new State('S2'))]);

        $this->fsm = $builder->getFSM();
    }

    public function testStatsGetterAndSetter()
    {
        $res = $this->fsm->getStates();

        $this->assertInstanceOf(States::class, $res);
        $this->assertNotEmpty($res->getStates());

        $this->fsm->setStates(new States([]));
        $res = $this->fsm->getStates();

        $this->assertInstanceOf(States::class, $res);
        $this->assertEmpty($res->getStates());
    }

    public function testAlphabetGetterAndSetter()
    {
        $res = $this->fsm->getAlphabet();

        $this->assertInstanceOf(Alphabet::class, $res);
        $this->assertNotEmpty($res->getLetters());

        $this->fsm->setAlphabet(new Alphabet([]));
        $res = $this->fsm->getAlphabet();

        $this->assertInstanceOf(Alphabet::class, $res);
        $this->assertEmpty($res->getLetters());
    }

    public function testInitStateGetterAndSetter()
    {
        $res = $this->fsm->getInitState();

        $this->assertInstanceOf(State::class, $res);
        $this->assertEquals('S1', $res->getName());

        $this->fsm->setInitState(new State('S2'));
        $res = $this->fsm->getInitState();

        $this->assertInstanceOf(State::class, $res);
        $this->assertEquals('S2', $res->getName());
    }

    public function testFinalStatesGetterAndSetter()
    {
        $res = $this->fsm->getFinalStates();

        $this->assertInstanceOf(FinalStates::class, $res);
        $this->assertNotEmpty($res->getStates());

        $this->fsm->setFinalStates(new FinalStates([]));
        $res = $this->fsm->getFinalStates();

        $this->assertInstanceOf(FinalStates::class, $res);
        $this->assertEmpty($res->getStates());
    }

    public function testTransitionsGetterAndSetter()
    {
        $res = $this->fsm->getTransitions();

        $this->assertInstanceOf(Transitions::class, $res);
        $this->assertNotEmpty($res->getTransitions());

        $this->fsm->setTransitions(new Transitions([]));
        $res = $this->fsm->getTransitions();

        $this->assertInstanceOf(Transitions::class, $res);
        $this->assertEmpty($res->getTransitions());
    }
}
