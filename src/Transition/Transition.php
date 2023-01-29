<?php

declare(strict_types=1);

namespace FSM\Transition;

use FSM\Alphabet\Letter;
use FSM\State\State;

class Transition
{
    /**
     * The start point of the State
     *
     * @var State
     */
    private State $state;

    /**
     * The input alphabet
     *
     * @var Letter
     */
    private Letter $input;

    /**
     * The State destination of this transition
     *
     * @var State
     */
    private State $destination;

    /**
     * Constructor
     *
     * @param State $state
     * @param Letter $input
     * @param State $destination
     */
    public function __construct(State $state, Letter $input, State $destination)
    {
        $this->state = $state;
        $this->input = $input;
        $this->destination = $destination;
    }

    /**
     * Getter for $state instance variable
     *
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * Getter for $input instance variable
     *
     * @return Letter
     */
    public function getInput(): Letter
    {
        return $this->input;
    }

    /**
     * Getter for $destination instance variable
     *
     * @return State
     */
    public function getDestination(): State
    {
        return $this->destination;
    }
}
