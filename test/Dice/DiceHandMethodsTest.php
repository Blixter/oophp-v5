<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandMethodsTest extends TestCase
{
    /**
     * Verify that the method 'sum' returns the right value.
     */
    public function testSum()
    {
        $diceHand = new DiceHand();

        $values = $diceHand->values();
        $exp = array_sum($values);
        $res = $diceHand->sum();
        $this->assertEquals($exp, $res);
    }


    /**
     * Verify that the method 'average' returns the right value.
     */
    public function testAverage()
    {
        $diceHand = new DiceHand();

        $values = $diceHand->values();
        $sum = array_sum($values);
        $length = $diceHand->amountOfDices();
        $exp = ($sum / $length);
        $res = $diceHand->average();
        $this->assertEquals($exp, $res);
    }
}
