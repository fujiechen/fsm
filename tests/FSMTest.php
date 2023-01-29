<?php

declare(strict_types=1);

namespace Tests;

use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use FSM\FSM;
use FSM\State\FinalState;
use FSM\State\FinalStates;
use FSM\State\State;
use FSM\State\States;
use FSM\Transition\Transition;
use FSM\Transition\Transitions;
use PHPUnit\Framework\TestCase;

class FSMTest extends TestCase
{
    public function testConstructorAndPassValidation()
    {
        $res = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $this->assertInstanceOf(FSM::class, $res);
        $this->assertEquals('S1', $res->getCurrState()->getName());
    }

    public function testBuildFromArray()
    {
        $res = FSM::buildFromArray(
            [new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')],
            [new Letter('1'), new Letter('2'), new Letter('3')],
            new State('S1'),
            [
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ],
            [
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ]
        );

        $this->assertInstanceOf(FSM::class, $res);
        $this->assertEquals('S1', $res->getCurrState()->getName());
    }

    public function testValidateInitializationDataAndFailOnInitStateNotInsideStates()
    {
        $this->expectExceptionMessage(FSM::VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE);

        FSM::validateInitializationData(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S100'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );
    }

    public function testValidateInitializationDataAndFailOnFinalStatesNotWithinStates()
    {
        $this->expectExceptionMessage(FSM::VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE);

        FSM::validateInitializationData(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S5', '5'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );
    }

    public function testValidateInitializationDataAndFailOnTransitionValidation()
    {
        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE);

        FSM::validateInitializationData(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('5'), new State('S2'))
            ])
        );
    }

    public function testGetStates()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getStates();

        $this->assertInstanceOf(States::class, $res);
    }

    public function testGetAlphabet()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getAlphabet();

        $this->assertInstanceOf(Alphabet::class, $res);
    }

    public function testGetInitState()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getInitState();

        $this->assertInstanceOf(State::class, $res);
    }

    public function testGetFinalStates()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getFinalStates();

        $this->assertInstanceOf(FinalStates::class, $res);
    }

    public function testGetTransitions()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getTransitions();

        $this->assertInstanceOf(Transitions::class, $res);
    }

    public function testGetGetCurrState()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $res = $fsm->getCurrState();

        $this->assertInstanceOf(State::class, $res);
    }

    public function testProcessAndSuccessUpdateTheCurrentState()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $fsm->process(new Letter('1'));

        $this->assertEquals('S2', $fsm->getCurrState()->getName());
    }

    public function testProcessAndFailOnInvalidInput()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $this->expectExceptionMessage(FSM::INVALID_INPUT_WARNING);

        $fsm->process(new Letter('4'));
    }

    public function testProcessAndFailOnNoTransitionFound()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2'))
            ])
        );

        $this->expectExceptionMessage(FSM::NOT_TRANSITION_FOUND_WARNING);

        $fsm->process(new Letter('2'));
    }

    public function testProcessListAndSuccessUpdateTheCurrentState()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2')),
                new Transition(new State('S2'), new Letter('2'), new FinalState('S3', '3')),
            ])
        );

        $fsm->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('S3', $fsm->getCurrState()->getName());
    }

    public function testGetFinalOutputAndSuccess()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2')),
                new Transition(new State('S2'), new Letter('2'), new FinalState('S3', '3')),
            ])
        );

        $fsm->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('3', $fsm->getFinalOutput());
    }

    public function testGetFinalOutputAndFailOnNotReachFinalState()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2')),
                new Transition(new State('S2'), new Letter('2'), new FinalState('S3', '3')),
            ])
        );

        $fsm->processList([new Letter('1')]);

        $res = $fsm->getFinalOutput();

        $this->assertEquals(FSM::NOT_REACH_FINAL_STATE_WARNING, $res);
    }

    public function testReset()
    {
        $fsm = new FSM(
            new States([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]),
            new Alphabet([new Letter('1'), new Letter('2'), new Letter('3')]),
            new State('S1'),
            new FinalStates([
                new FinalState('S3', '3'),
                new FinalState('S4', '4'),
            ]),
            new Transitions([
                new Transition(new State('S1'), new Letter('1'), new State('S2')),
                new Transition(new State('S2'), new Letter('2'), new FinalState('S3', '3')),
            ])
        );

        $fsm->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('S3', $fsm->getCurrState()->getName());

        $fsm->reset();

        $this->assertEquals('S1', $fsm->getCurrState()->getName());
    }
}
