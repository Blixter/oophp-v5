<?php
namespace Blixter\Dice;

class ComputerPlayer extends Player
{
    /**
     * If computer rolled atleast one six, save.
     * @return str save or continue
     */
    public function makeDecision()
    {
        $rolls = $this->dices->getHistogramSerie();
        $roundPoints = array_sum($rolls);
        $currentScore = $this->getScore();
        $serieAmount = sizeof($rolls);
        $highDices = 0;

        // If the computer has more than 50 points on the 
        // current round save the points.
        if ($roundPoints > 50) {
            return "save";
        }

        // If the points for the current roll serie is enough 
        // to win the game, return 'save'.
        if ($roundPoints + $currentScore >= 100) {
            return "save";
        }

        // Check how many dices has the value 5 or 6.
        foreach ($rolls as $roll) {
            if ($roll == 5 || $roll == 6) {
                $highDices++;
            } 
        }

        // If more than half of the rolled dices
        // is high value dices return 'save'.
        if ($highDices > ($serieAmount/2)) {
            return "save";
        }

        return "continue";
    }
}
