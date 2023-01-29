<?php

declare(strict_types=1);

namespace Test\FSM;

use FSM\Alphabet\Letter;
use FSM\FSM\FSM;
use FSM\FSM\FSMArrayBuilder;
use FSM\FSM\FSMService;
use FSM\State\FinalState;
use FSM\State\State;
use FSM\Transition\Transition;
use PHPUnit\Framework\TestCase;

class FSMServiceTest extends TestCase
{
    private FSMService $fsmService;

    public function setUp(): void
    {
        parent::setUp();

        $builder = new FSMArrayBuilder();
        $builder->createFSM();
        $builder->setStates([new State('S1'), new State('S2'), new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setAlphabet([new Letter('1'), new Letter('2'), new Letter('3')]);
        $builder->setInitState(new State('S1'));
        $builder->setFinalState([new FinalState('S3', '3'), new FinalState('S4', '4')]);
        $builder->setTransitions([
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new FinalState('S3', '3'))
        ]);

        $fsm = $builder->getFSM();
        $this->fsmService = new FSMService($fsm);
    }

    public function testGetFsm(): void
    {
        $res = $this->fsmService->getFsm();
        $this->assertInstanceOf(FSM::class, $res);
    }

    public function testProcessAndSuccessUpdateTheCurrentState()
    {
        $this->fsmService->process(new Letter('1'));

        $this->assertEquals('S2', $this->fsmService->getFsm()->getCurrState()->getName());
    }

    public function testProcessAndFailOnInvalidInput()
    {
        $this->expectExceptionMessage(FSMService::INVALID_INPUT_WARNING);

        $this->fsmService->process(new Letter('4'));
    }

    public function testProcessAndFailOnNoTransitionFound()
    {
        $this->expectExceptionMessage(FSMService::NOT_TRANSITION_FOUND_WARNING);

        $this->fsmService->process(new Letter('2'));
    }

    public function testProcessListAndSuccessUpdateTheCurrentState()
    {
        $this->fsmService->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('S3', $this->fsmService->getFsm()->getCurrState()->getName());
    }

    public function testGetFinalOutputAndSuccess()
    {
        $this->fsmService->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('3', $this->fsmService->getFinalOutput());
    }

    public function testGetFinalOutputAndFailOnNotReachFinalState()
    {
        $this->fsmService->processList([new Letter('1')]);

        $res = $this->fsmService->getFinalOutput();

        $this->assertEquals(FSMService::NOT_REACH_FINAL_STATE_WARNING, $res);
    }

    public function testReset()
    {
        $this->fsmService->processList([new Letter('1'), new Letter('2')]);

        $this->assertEquals('S3', $this->fsmService->getFsm()->getCurrState()->getName());

        $this->fsmService->reset();

        $this->assertEquals('S1', $this->fsmService->getFsm()->getCurrState()->getName());
    }
}
