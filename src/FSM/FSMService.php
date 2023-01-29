<?php

declare(strict_types=1);

namespace FSM\FSM;

use Exception;
use FSM\Alphabet\Letter;

/**
 * This class implements the Finite State Machine (FSM) based on the following abstract definition:
 *
 * A finite automaton (FA) is a 5-tuple (Q,Σ,q0,F,δ) where,
 * Q is a finite set of states;
 * Σ is a finite input alphabet;
 * q0 ∈ Q is the initial state;
 * F ⊆ Q is the set of accepting/final states; and
 * δ:Q×Σ→Q is the transition function.
 *
 * For any element q of Q and any symbol σ∈Σ, we interpret δ(q,σ) as the state to which the FA moves,
 * if it is in state q and receives the input σ.
 *
 * The API of this library is designed for use by other developers.
 */
class FSMService
{
    public const NOT_REACH_FINAL_STATE_WARNING = 'Not reach the final state yet!';
    public const INVALID_INPUT_WARNING = 'The given input is not in alphabet!';
    public const NOT_TRANSITION_FOUND_WARNING = 'Not available transition found!';

    private FSM $fsm;

    public function __construct(FSM $fsm)
    {
        $this->fsm = $fsm;
    }

    public function getFsm(): FSM
    {
        return $this->fsm;
    }

    /**
     * Process one alphabet and update the FSM
     *
     * @param Letter $input
     * @return void
     * @throws Exception
     */
    public function process(Letter $input): void
    {
        // Check if the given input is valid
        if (!$this->fsm->getAlphabet()->contains($input)) {
            throw new Exception(self::INVALID_INPUT_WARNING);
        }

        $transition = $this->fsm->getTransitions()->findByStateAndLetter(
            $this->fsm->getCurrState(),
            $input
        );

        // Check if there is any valid transition
        if (is_null($transition)) {
            throw new Exception(self::NOT_TRANSITION_FOUND_WARNING);
        }

        // Update current state to be the destination of the transition
        $this->fsm->setCurrState($transition->getDestination());
    }

    /**
     * Process a list of alphabets and update the FSM
     *
     * @param array $inputList
     * @return void
     * @throws Exception
     */
    public function processList(array $inputList): void
    {
        foreach($inputList as $input) {
            $this->process($input);
        }
    }

    /**
     * Get the final output after the machine processes
     *
     * @return string
     */
    public function getFinalOutput(): string
    {
        // Check if the current state is final state
        if(!$this->fsm->getFinalStates()->contains($this->fsm->getCurrState())) {
            return self::NOT_REACH_FINAL_STATE_WARNING;
        }

        // use the current state output
        return $this->fsm->getCurrState()->getFinalOutput();
    }

    /**
     * Reset the FSM back to the initial state
     *
     * @return void
     */
    public function reset(): void
    {
        $this->fsm->setCurrState($this->fsm->getInitState());
    }
}
