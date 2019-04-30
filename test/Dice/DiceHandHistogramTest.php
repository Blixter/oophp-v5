<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandHistogramCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the method 'getHistogramMax' 
     * work as expected.
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
     * Construct object and verify that the method 'roll' 
     * work as expected.
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
     * Construct object and verify that the method 'histogramMin' 
     * work as expected.
     */
    public function testHistogramMin()
    {
        $diceHand = new DiceHandHistogram();

        $res = $diceHand->getHistogramMin();

        $this->assertEquals(1, $res);
    }

    /**
     * Construct object and verify that the method 'histogramMax' 
     * work as expected.
     */
    public function testHistogramMax()
    {
        $diceHand = new DiceHandHistogram();

        $res = $diceHand->getHistogramMin();

        $this->assertEquals(1, $res);
    }
}
