<?php

declare(strict_types=1);

namespace Tests;

use FSM\Alphabet\Letter;
use FSM\FSM\FSM;
use FSM\FSM\FSMObjectBuilder;
use FSM\State\FinalState;
use FSM\State\State;
use FSM\Transition\Transition;
use FSM\Transition\Transitions;
use PHPUnit\Framework\TestCase;

class FSMObjectBuilderTest extends TestCase
{
    public function testGetFsmAndFailOnInitStateNotInsideStates()
    {
        $builder = new FSMObjectBuilder();
        $builder->createFSM();

        $builder->addState(new State('S1'));
        $builder->addState(new State('S2'));
        $builder->addState(new FinalState('S3', '3'));
        $builder->addState(new FinalState('S4', '4'));

        $builder->addLetter(new Letter('1'));
        $builder->addLetter(new Letter('2'));
        $builder->addLetter(new Letter('3'));

        $builder->setInitState(new State('S100'));

        $builder->addFinalState(new FinalState('S3', '3'));
        $builder->addFinalState(new FinalState('S4', '4'));

        $builder->addTransition(new Transition(new State('S1'), new Letter('1'), new State('S2')));

        $this->expectExceptionMessage(FSM::VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsmAndFailOnFinalStatesNotWithinStates()
    {
        $builder = new FSMObjectBuilder();
        $builder->createFSM();

        $builder->addState(new State('S1'));
        $builder->addState(new State('S2'));
        $builder->addState(new FinalState('S3', '3'));
        $builder->addState(new FinalState('S4', '4'));

        $builder->addLetter(new Letter('1'));
        $builder->addLetter(new Letter('2'));
        $builder->addLetter(new Letter('3'));

        $builder->setInitState(new State('S1'));

        $builder->addFinalState(new FinalState('S3', '3'));
        $builder->addFinalState(new FinalState('S5', '5'));

        $builder->addTransition(new Transition(new State('S1'), new Letter('1'), new State('S2')));

        $this->expectExceptionMessage(FSM::VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsmAndFailOnTransitionValidation()
    {

        $builder = new FSMObjectBuilder();
        $builder->createFSM();

        $builder->addState(new State('S1'));
        $builder->addState(new State('S2'));
        $builder->addState(new FinalState('S3', '3'));
        $builder->addState(new FinalState('S4', '4'));

        $builder->addLetter(new Letter('1'));
        $builder->addLetter(new Letter('2'));
        $builder->addLetter(new Letter('3'));

        $builder->setInitState(new State('S1'));

        $builder->addFinalState(new FinalState('S3', '3'));
        $builder->addFinalState(new FinalState('S4', '4'));

        $builder->addTransition(new Transition(new State('S1'), new Letter('100'), new State('S2')));

        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE);

        $builder->getFSM();
    }

    public function testGetFsm()
    {

        $builder = new FSMObjectBuilder();
        $builder->createFSM();

        $builder->addState(new State('S1'));
        $builder->addState(new State('S2'));
        $builder->addState(new FinalState('S3', '3'));
        $builder->addState(new FinalState('S4', '4'));

        $builder->addLetter(new Letter('1'));
        $builder->addLetter(new Letter('2'));
        $builder->addLetter(new Letter('3'));

        $builder->setInitState(new State('S1'));

        $builder->addFinalState(new FinalState('S3', '3'));
        $builder->addFinalState(new FinalState('S4', '4'));

        $builder->addTransition(new Transition(new State('S1'), new Letter('1'), new State('S2')));

        $res = $builder->getFSM();

        $this->assertInstanceOf(FSM::class, $res);
    }
}
