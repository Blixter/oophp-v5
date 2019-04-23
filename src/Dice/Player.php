<?php

namespace Blixter\Dice;

/**
 * Player class
 */
class Player
{

    /**
     * @var int $score   Score in the game.
     */
    private $score;


    /**
     * Constructor to create a Player.
     * @param int $dies Number of dices to create, defaults to five.
     */
    public function __construct(int $dies = 5)
    {
        $this->score = 0;
        $this->dices = new DiceHand($dies);
    }

    /**
     * Add score
     * @param int $playerScore Points to add to score.
     *
     * @return void
     */
    public function addScore($playerScore)
    {
        $this->score = $this->score + $playerScore;
    }

    /**
     * Get score
     *
     * @return int with player score.
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Roll dices in hand
     *
     * @return void
     */
    public function rollDices()
    {
        $this->dices->roll();
    }

    /**
     * return last roll
     *
     * @return void
     */
    public function getLastRoll()
    {
        return $this->dices->values();
    }

    /**
     * return last roll
     *
     * @return void
     */
    public function getLastRollSum()
    {
        return $this->dices->sum();
    }

    /**
     *
     */
    public function checkIfRolledOne()
    {
        $lastRollArray = $this->getLastRoll();
        return (in_array(1, $lastRollArray));
    }
}
