<?php
namespace Blixter\Dice;

class ComputerPlayer extends Player
{
    /**
     * Inherit from Player.
     */
    public function __construct(int $dies = 5)
    {
        parent::__construct($dies);
    }

    /**
     * Random choice if to save or continue
     * @return str save or continue
     */
    public function makeDecision()
    {
        $choice = rand(1, 2);
        if ($choice == 1) {
            return "save";
        }
        if ($choice == 2) {
            return "continue";
        }
    }
}
