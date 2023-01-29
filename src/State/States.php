<?php

declare(strict_types=1);

namespace FSM\State;

use Exception;

/**
 * This class is set of State objects
 */
class States
{
    public const VALIDATE_INIT_STATES_EXCEPTION_MESSAGE = 'States array contains none State object!';

    /**
     * A finite set of states.
     *
     * @var array State objects
     */
    private array $states;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct(array $states)
    {
        foreach ($states as $state) {
            if (!($state instanceof State)) {
                throw new Exception(self::VALIDATE_INIT_STATES_EXCEPTION_MESSAGE);
            }
        }

        $this->states = $states;
    }

    public function push(State $state): void
    {
        $this->states[] = $state;
    }

   public function getStates(): array
   {
       return $this->states;
   }

    /**
     * Check if given other state is within the current state list
     *
     * @param State $otherState
     * @return bool
     */
   public function contains(State $otherState): bool
   {
       $found = false;
       // check each state until find the match
       foreach ($this->states as $state) {
           $found = $otherState->isEqual($state);
           if($found) {
               break;
           }
       }
       return $found;
   }

    /**
     * Check if all states are within given states
     *
     * @param States $otherStates
     * @return bool
     */
   public function within(States $otherStates): bool
   {
       // Check each state is within other states
       foreach ($this->states as $state) {
           // if other states does not contain any of the state, return false immediately
           if(!$otherStates->contains($state)) {
                return false;
           }
       }

       return true;
   }
}
