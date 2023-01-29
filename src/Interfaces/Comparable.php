<?php

declare(strict_types=1);

namespace FSM\Interfaces;
/**
 * This interface defines comparable object structure
 */
interface Comparable
{
    public function getCompareValue(): string;

    public function isEqual(Comparable $other): bool;
}
