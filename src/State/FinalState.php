<?php

declare(strict_types=1);

namespace FSM\State;

/**
 * This class is for final state, it extends State class
 * and add the final output if it finishes on the current state
 */
class FinalState extends State
{
    /**
     * The output string
     *
     * @var string
     */
    private string $output;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $output
     */
    public function __construct(
        string $name,
        string $output
    )
    {
        parent::__construct($name);

        $this->output = $output;
    }

    /**
     * Get the final output in string type
     *
     * @return string
     */
    public function getFinalOutput(): string
    {
        return $this->output;
    }

    /**
     * Override the parent function to include the output
     *
     * @return string
     */
    public function getCompareValue(): string
    {
        return parent::getCompareValue() . '-' . $this->output;
    }
}
