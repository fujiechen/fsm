<?php

declare(strict_types=1);

namespace FSM\State;

use Exception;

/**
 * This class is set of Final State objects
 */
class FinalStates extends States
{
    public const VALIDATE_INIT_FINAL_STATES_OBJECT_EXCEPTION_MESSAGE = 'Final States array contains none Final State object!';

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct(array $states)
    {
        parent::__construct($states);

        foreach ($states as $state) {
            if (!($state instanceof FinalState)) {
                throw new Exception(self::VALIDATE_INIT_FINAL_STATES_OBJECT_EXCEPTION_MESSAGE);
            }
        }
    }

    /**
     * Extend the parent function to make sure the new pushed object is FinalState
     *
     * @throws Exception
     */
    public function push(State $state): void
    {
        if (!($state instanceof FinalState)) {
            throw new Exception(self::VALIDATE_INIT_FINAL_STATES_OBJECT_EXCEPTION_MESSAGE);
        }

        parent::push($state);
    }
}
