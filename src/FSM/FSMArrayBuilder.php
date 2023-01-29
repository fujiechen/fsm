<?php

declare(strict_types=1);

namespace FSM\FSM;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\Interfaces\Builder;
use FSM\State\FinalStates;
use FSM\State\State;
use FSM\State\States;
use FSM\Transition\Transitions;

class FSMArrayBuilder implements Builder
{
    private FSM $fsm;

    public function createFSM(): void
    {
        $this->fsm = new FSM();
    }

    /**
     * @throws Exception
     */
    public function getFSM(): FSM
    {
        $this->fsm->validate();
        return $this->fsm;
    }

    /**
     * @throws Exception
     */
    public function setStates(array $states): void
    {
        $this->fsm->setStates(new States($states));
    }

    /**
     * @throws Exception
     */
    public function setAlphabet(array $alphabet): void
    {
        $this->fsm->setAlphabet(new Alphabet($alphabet));
    }

    /**
     * @throws Exception
     */
    public function setInitState(State $state): void
    {
        $this->fsm->setInitState($state);
        $this->fsm->setCurrState($state);
    }

    /**
     * @throws Exception
     */
    public function setFinalState(array $finalStates): void
    {
        $this->fsm->setFinalStates(new FinalStates($finalStates));
    }

    /**
     * @throws Exception
     */
    public function setTransitions(array $transitions): void
    {
        $this->fsm->setTransitions(new Transitions($transitions));
    }
}
