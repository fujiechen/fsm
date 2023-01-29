<?php

declare(strict_types=1);

namespace Tests;

use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use FSM\FSM\FSM;
use FSM\FSM\FSMArrayBuilder;
use FSM\State\FinalState;
use FSM\State\State;
use FSM\Transition\Transition;
use FSM\Transition\Transitions;
use PHPUnit\Framework\TestCase;

class FSMArrayBuilderTest extends TestCase
{
    public function testGetFsmAndFailOnInitStateNotInsideStates()
    {
        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S100'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setTransitions([new Transition(new State('S1'), new Letter('1'), new State('S2'))]);

        $this->expectExceptionMessage(FSM::VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsmAndFailOnFinalStatesNotWithinStates()
    {
        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S1'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S5', '5')]);
        $builder->setTransitions([new Transition(new State('S1'), new Letter('1'), new State('S2'))]);

        $this->expectExceptionMessage(FSM::VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsmAndFailOnTransitionValidation()
    {

        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S1'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setTransitions([new Transition(new State('S2'), new Letter('100'), new State('S2'))]);

        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsm()
    {

        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S1'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setTransitions([new Transition(new State('S2'), new Letter('2'), new State('S2'))]);

        $res = $builder->getFSM();

        $this->assertInstanceOf(FSM::class, $res);
    }
}
