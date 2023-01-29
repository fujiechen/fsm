<?php

declare(strict_types=1);

namespace FSM\State;

use FSM\Interfaces\Comparable;

/**
 * This class is for State along with its name
 *
 * This class implements Comparable interface so it can compare with other States
 */
class State implements Comparable
{
    private string $name;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Getter for the $name instance variable
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value for comparison
     * Use $name for comparison
     *
     * Comparable interface defined function
     *
     * @return string
     */
    public function getCompareValue(): string
    {
        return $this->name;
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
        return $this->getCompareValue() === $other->getCompareValue();
    }
}
