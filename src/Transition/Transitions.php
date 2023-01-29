<?php

declare(strict_types=1);

namespace FSM\Transition;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use FSM\State\State;
use FSM\State\States;

/**
 * This class is set of State objects
 */
class Transitions
{
    public const VALIDATE_INIT_TRANSITIONS_OBJECT_EXCEPTION_MESSAGE = 'Transitions array contains none Transition object!';
    public const VALIDATE_INIT_TRANSITIONS_WRONG_STATE_EXCEPTION_MESSAGE = 'One or more Transition have States that are not in States array!';
    public const VALIDATE_INIT_TRANSITIONS_WRONG_DESTINATION_EXCEPTION_MESSAGE = 'One or more Transition have Destination State that are not in States array!';
    public const VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE = 'One or more Transition have inputs that are not in Alphabet array!';

    /**
     * a set of Transition objects
     *
     * @var array Transition objects
     */
    private array $transitions;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct(array $transitions)
    {
        foreach ($transitions as $transition) {
            if (!($transition instanceof Transition)) {
                throw new Exception(self::VALIDATE_INIT_TRANSITIONS_OBJECT_EXCEPTION_MESSAGE);
            }
        }

        $this->transitions = $transitions;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function push(Transition $transition): void
    {
        $this->transitions[] = $transition;
    }

    /**
     * Validate all transitions if
     * - all states are within given States
     * - all input are within given Alphabet
     * - all destination are within given States
     *
     * @param States $states
     * @param Alphabet $alphabet
     * @return bool
     * @throws Exception
     */
    public function validate(States $states, Alphabet $alphabet): bool
    {
        /** @var Transition $transition */
        foreach ($this->transitions as $transition) {
            if (!$states->contains($transition->getState())) {
                throw new Exception(self::VALIDATE_INIT_TRANSITIONS_WRONG_STATE_EXCEPTION_MESSAGE);
            }
            if (!$states->contains($transition->getDestination())) {
                throw new Exception(self::VALIDATE_INIT_TRANSITIONS_WRONG_DESTINATION_EXCEPTION_MESSAGE);
            }
            if (!$alphabet->contains($transition->getInput())) {
                throw new Exception(self::VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE);
            }
        }

        return true;
    }

    /**
     * Find the transition by the given state and the given letter
     *
     * @param State $state
     * @param Letter $input
     * @return Transition|null
     */
    public function findByStateAndLetter(State $state, Letter $input): ?Transition
    {
        /** @var Transition $transition */
        foreach($this->transitions as $transition) {
            // Check both state and input are matched
            $isStateMatched = $state->isEqual($transition->getState());
            $isInputMatched = $input->isEqual($transition->getInput());
            if($isStateMatched && $isInputMatched) {
                return $transition;
            }
        }

        // if not found
        return null;
    }
}
