<?php

declare(strict_types=1);

namespace FSM\Alphabet;

use FSM\Interfaces\Comparable;
use FSM\Interfaces\Printable;

/**
 * This class is for Letter within Alphabet, it implements Comparable
 */
class Letter implements Comparable
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Getter for $value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get the value for comparison
     *
     * Comparable interface defined function
     *
     * @return string
     */
    public function getCompareValue(): string
    {
        return $this->value;
    }

    /**
     * Check if another Comparable object is equal to self by comparing compare values
     *
     * Comparable interface defined function
     *
     * @param Comparable $other
     * @return bool
     */
    public function isEqual(Comparable $other): bool
    {
        return $other->getCompareValue() === $this->getCompareValue();
    }
}
