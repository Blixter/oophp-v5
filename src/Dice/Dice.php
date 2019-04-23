<?php
namespace Blixter\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{

    /**
     * @var int $lastRoll   value of the rolled dice.
     */
    // private $dice;
    private $lastRoll;

    /**
     * Constructor to create a Dice.
     * @param int   $throws Amount of throws.
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->roll();
    }

    /**
     * roll the dice
     *
     * @return int random number between 1 and number of sides on dice.
     */
    public function roll()
    {
        $rolled = rand(1, $this->sides);
        $this->lastRoll = $rolled;
        return $rolled;
    }


    /**
     * Get the value of the last thrown dice.
     *
     * @return array with the thrown dices.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
