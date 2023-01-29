<?php

declare(strict_types=1);

namespace FSM\Alphabet;

use Exception;

/**
 * This class is set of State objects
 */
class Alphabet
{
    public const VALIDATE_INIT_ALPHABET_EXCEPTION_MESSAGE = 'Alphabet array contains none Letter object!';

    /**
     * Alphabet of a set of Letter objects
     *
     * @var array Letter objects
     */
    private array $letters;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct(array $letters)
    {
        foreach ($letters as $letter) {
            if (!($letter instanceof Letter)) {
                throw new Exception(self::VALIDATE_INIT_ALPHABET_EXCEPTION_MESSAGE);
            }
        }

        $this->letters = $letters;
    }

    public function getLetters(): array
    {
        return $this->letters;
    }

    public function push(Letter $letter): void
    {
        $this->letters[] = $letter;
    }

    /**
     * Check if given other Letter is within the current Alphabet list
     *
     * @param Letter $otherLetter
     * @return bool
     */
    public function contains(Letter $otherLetter): bool
    {
        $found = false;
        // check each letter until find the match
        foreach ($this->letters as $letter) {
            $found = $otherLetter->isEqual($letter);
            if($found) {
                break;
            }
        }
        return $found;
    }
}
