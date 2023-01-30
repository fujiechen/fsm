<?php

declare(strict_types=1);

namespace FSM\Interfaces;

use FSM\Alphabet\Letter;
use FSM\FSM\FSM;

interface FSMServiceInterface
{
    public function getFsm(): FSM;

    public function process(Letter $input): void;

    public function processList(array $inputList): void;

    public function getFinalOutput(): string;

    public function reset(): void;
}
