<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ComputerPlayer.
 */
class ComputerPlayerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the object returns a string
     */
    public function testMakeDecisionReturnsString()
    {
        $computer = new ComputerPlayer();

        $res = $computer->makeDecision();
        $exp = 'string';

        $this->assertInternalType($exp, $res);
    }

    /**
     * Construct object and verify that the object returns 'save'
     * when expected.
     */
    public function testMakeDecisionReturnSave()
    {
        $computer = new ComputerPlayer();
        $computer->addScore(90); 

        for ($i = 0; $i <= 100; $i++) {
            $computer->dices->roll();
        
            $rolls = $computer->dices->getHistogramSerie();
            $roundPoints = array_sum($rolls);


            if ($roundPoints > 100) {
                $this->assertEquals("save", $computer->makeDecision());
            }

            if ($computer->getscore() + $roundPoints >= 100) {
                $this->assertEquals("save", $computer->makeDecision());
            }
        }
    }


    /**
     * Construct object and verify that the method returns 'save'
     * when more than half of the rolled dices has high values.
     */
    public function testMakeDecisionHighDices()
    {
        while (true) {
            $computer = new ComputerPlayer();
            $highDices = 0;
            $computer->dices->roll();
            $rolls = $computer->dices->getHistogramSerie();
            $serieAmount = sizeof($rolls);
            foreach ($rolls as $roll) {
                if ($roll == 5 || $roll == 6) {
                    $highDices++;
                }
            }
            if ($highDices > ($serieAmount/2)) {
                $this->assertEquals("save", $computer->makeDecision());
                break;
            }
        }
    }
}
