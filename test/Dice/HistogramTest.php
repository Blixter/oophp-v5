<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Histogram.
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the method 'getSerie' returns an array.
     */
    public function testGetserie()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Blixter\Dice\Histogram", $histogram);

        $this->assertInternalType('array', $histogram->getSerie());
    }

    /**
     * Construct object and verify that the method 'getAsText' returns a string.
     */
    public function testGetAsText()
    {
        $histogram = new Histogram();

        $diceHand = new DiceHandHistogram();

        for ($i = 0; $i <= 20; $i++) {
            $diceHand->roll();
        }

        $histogram->injectData($diceHand);

        $histogram->getAsText();

        $this->assertInternalType('string', $histogram->getAsText());
    }
}
