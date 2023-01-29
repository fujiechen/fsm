<?php

declare(strict_types=1);

namespace FSM\FSM;

use Exception;
use FSM\Alphabet\Letter;
use FSM\Interfaces\Builder;
use FSM\State\FinalState;
use FSM\State\State;
use FSM\Transition\Transition;

class FSMObjectBuilder implements Builder
{
    private FSM $fsm;

    public function createFSM(): void
    {
        $this->fsm = new FSM();
    }

    public function getFSM(): FSM
    {
        $this->fsm->validate();
        return $this->fsm;
    }

    /**
     * @throws Exception
     */
    public function addState(State $state): void
    {
        $this->fsm->getStates()->push($state);
    }

    /**
     * @throws Exception
     */
    public function addLetter(Letter $letter): void
    {
        $this->fsm->getAlphabet()->push($letter);
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
    public function addFinalState(FinalState $finalState): void
    {
        $this->fsm->getFinalStates()->push($finalState);
    }

    /**
     * @throws Exception
     */
    public function addTransition(Transition $transition): void
    {
        $this->fsm->getTransitions()->push($transition);
    }
}
