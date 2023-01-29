<?php

declare(strict_types=1);

namespace FSM\FSM;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\State\FinalStates;
use FSM\State\State;
use FSM\State\States;
use FSM\Transition\Transitions;

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
class FSM
{
    public const VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE = 'Initial State is not in States array!';
    public const VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE = 'One or more Final States are not in States array!';

    /**
     * A finite set of states.
     *
     * @var States
     */
    private States $states;

    /**
     * A finite input alphabet.
     *
     * @var Alphabet
     */
    private Alphabet $alphabet;

    /**
     * The initial state.
     *
     * @var State
     */
    private State $initState;

    /**
     * The set of accepting/final states.
     *
     * @var FinalStates
     */
    private FinalStates $finalStates;

    /**
     * The set of transition functions.
     *
     * @var Transitions
     */
    private Transitions $transitions;

    /**
     * The current state.
     *
     * @var State
     */
    private State $currState;

    public function __construct()
    {
        $this->states = new States([]);
        $this->alphabet = new Alphabet([]);
        $this->finalStates = new FinalStates([]);
        $this->transitions = new Transitions([]);
    }

    /**
     * Check all data are valid to prevent potential processing issues
     *
     * @throws Exception
     */
    public function validate(): bool
    {
        // Check init state is within states array
        if (!$this->states->contains($this->initState)) {
            throw new Exception(self::VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE);
        }

        // Check final states
        if (!$this->finalStates->within($this->states)) {
            throw new Exception(self::VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE);
        }

        // Check transitions
        $this->transitions->validate($this->states, $this->alphabet);

        return true;
    }

    /**
     * @return States
     */
    public function getStates(): States
    {
        return $this->states;
    }

    /**
     * @param States $states
     */
    public function setStates(States $states): void
    {
        $this->states = $states;
    }

    /**
     * @return Alphabet
     */
    public function getAlphabet(): Alphabet
    {
        return $this->alphabet;
    }

    /**
     * @param Alphabet $alphabet
     */
    public function setAlphabet(Alphabet $alphabet): void
    {
        $this->alphabet = $alphabet;
    }

    /**
     * @return State
     */
    public function getInitState(): State
    {
        return $this->initState;
    }

    /**
     * @param State $initState
     */
    public function setInitState(State $initState): void
    {
        $this->initState = $initState;
    }

    /**
     * @return FinalStates
     */
    public function getFinalStates(): FinalStates
    {
        return $this->finalStates;
    }

    /**
     * @param FinalStates $finalStates
     */
    public function setFinalStates(FinalStates $finalStates): void
    {
        $this->finalStates = $finalStates;
    }

    /**
     * @return Transitions
     */
    public function getTransitions(): Transitions
    {
        return $this->transitions;
    }

    /**
     * @param Transitions $transitions
     */
    public function setTransitions(Transitions $transitions): void
    {
        $this->transitions = $transitions;
    }

    /**
     * @return State
     */
    public function getCurrState(): State
    {
        return $this->currState;
    }

    /**
     * @param State $currState
     */
    public function setCurrState(State $currState): void
    {
        $this->currState = $currState;
    }
}
