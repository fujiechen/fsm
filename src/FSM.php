<?php

declare(strict_types=1);

namespace FSM;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
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
    public const NOT_REACH_FINAL_STATE_WARNING = 'Not reach the final state yet!';
    public const INVALID_INPUT_WARNING = 'The given input is not in alphabet!';
    public const NOT_TRANSITION_FOUND_WARNING = 'Not available transition found!';

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

    /**
     * Constructor to construct a new Finite State Machine object.
     *
     * @param States $states
     * @param Alphabet $alphabet
     * @param State $initState
     * @param FinalStates $finalStates
     * @param Transitions $transitions
     * @throws Exception
     */
    public function __construct(
        States $states,
        Alphabet $alphabet,
        State $initState,
        FinalStates $finalStates,
        Transitions $transitions,
    )
    {
        FSM::validateInitializationData($states, $alphabet, $initState, $finalStates, $transitions);

        $this->states = $states;
        $this->alphabet = $alphabet;
        $this->initState = $initState;
        $this->finalStates = $finalStates;
        $this->transitions = $transitions;

        $this->currState = $initState;
    }

    /**
     * Builder design pattern to build the FSM from array
     *
     * @throws Exception
     */
    public static function buildFromArray(
        array $states,
        array $alphabet,
        State $initState,
        array $finalStates,
        array $transitions,
    ): self
    {
        $statesObj = new States($states);
        $alphabetObj = new Alphabet($alphabet);
        $finalStatesObj = new FinalStates($finalStates);
        $transitionsObj = new Transitions($transitions);

        return new self($statesObj, $alphabetObj, $initState, $finalStatesObj, $transitionsObj);
    }

    /**
     * Check all initialization data are valid to prevent potential processing issues
     *
     * @throws Exception
     */
    public static function validateInitializationData(
        States $states,
        Alphabet $alphabet,
        State $initState,
        FinalStates $finalStates,
        Transitions $transitions,
    ): bool
    {
        // Check init state is within states array
        if(!$states->contains($initState)) {
            throw new Exception(self::VALIDATE_INIT_INIT_STATE_EXCEPTION_MESSAGE);
        }

        // Check final states
        if(!$finalStates->within($states)) {
            throw new Exception(self::VALIDATE_INIT_FINAL_STATES_IN_STATES_EXCEPTION_MESSAGE);
        }

        // Check transitions
        $transitions->validate($states, $alphabet);

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
     * @return Alphabet
     */
    public function getAlphabet(): Alphabet
    {
        return $this->alphabet;
    }

    /**
     * @return State
     */
    public function getInitState(): State
    {
        return $this->initState;
    }

    /**
     * @return FinalStates
     */
    public function getFinalStates(): FinalStates
    {
        return $this->finalStates;
    }

    /**
     * @return Transitions
     */
    public function getTransitions(): Transitions
    {
        return $this->transitions;
    }

    /**
     * @return State
     */
    public function getCurrState(): State
    {
        return $this->currState;
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
        if (!$this->alphabet->contains($input)) {
            throw new Exception(self::INVALID_INPUT_WARNING);
        }

        $transition = $this->transitions->findByStateAndLetter(
            $this->currState,
            $input
        );

        // Check if there is any valid transition
        if (is_null($transition)) {
            throw new Exception(self::NOT_TRANSITION_FOUND_WARNING);
        }

        // Update current state to be the destination of the transition
        $this->currState = $transition->getDestination();
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
        if(!$this->finalStates->contains($this->currState)) {
            return self::NOT_REACH_FINAL_STATE_WARNING;
        }

        // use the current state output
        return $this->currState->getFinalOutput();
    }

    /**
     * Reset the FSM back to the initial state
     *
     * @return void
     */
    public function reset(): void
    {
        $this->currState = $this->initState;
    }
}
