<?php

declare(strict_types=1);

namespace FSM\Interfaces;

use FSM\FSM\FSM;

/**
 * This interface defines FSM Builder
 */
interface Builder
{
    public function createFSM(): void;

    public function getFSM(): FSM;
}
