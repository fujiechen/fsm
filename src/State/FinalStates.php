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
}
