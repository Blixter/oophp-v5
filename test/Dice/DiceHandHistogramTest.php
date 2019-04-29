<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandHistogramCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetHistogramMax()
    {
        $diceHand = new DiceHandHistogram();
        $this->assertInstanceOf("\Blixter\Dice\DiceHandHistogram", $diceHand);

        $res = $diceHand->getHistogramMax();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testRoll()
    {
        $diceHand = new DiceHandHistogram();

        $diceHand->roll();

        $rolledValues = $diceHand->values();

        $rolledSerie = $diceHand->getHistogramSerie();

        $this->assertEquals($rolledValues, $rolledSerie);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testHistogramMin()
    {
        $diceHand = new DiceHandHistogram();

        $res = $diceHand->getHistogramMin();

        $this->assertEquals(1, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testHistogramMax()
    {
        $diceHand = new DiceHandHistogram();

        $res = $diceHand->getHistogramMin();

        $this->assertEquals(1, $res);
    }
}
